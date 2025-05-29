<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
\DB::enableQueryLog();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

 

use App\Models\Category;
use App\Models\Product;
use App\Models\Manufacturer;
use App\Models\SubCategory;
use App\Jobs\ImportProductsFromExcel;


class ProductController extends Controller
{
    public function index()
    {
        // Fetch categories with their subcategories
        // The with() method preloads the subcategories for each category, which avoids the N+1 query issue
        $categories = Category::with('subcategories')->get();

        // Pass categories to the view
        return view('pages.products', ['categories' => $categories]);
    }

    public function category()
    {
        // Fetch categories with their subcategories
        // The with() method preloads the subcategories for each category, which avoids the N+1 query issue
        $categories = Category::with('subcategories')->get();

        // Pass categories to the view
        return view('pages.products_main', ['categories' => $categories]);
    }

    public function show(Request $request, $category = null)
    {
        $categories = Category::with('subcategories')->get();
        return view('pages.products', compact('categories', 'category'));
    }

    public function showByProducts($ProductID)
    {
        $product = Product::findOrFail($ProductID);
        $product->image_paths = json_decode($product->image_paths, true) ?? [];
        return view('pages.product_details', compact('product'));
    }

    public function showByManufacturer($manufacturerN)
{
    // Fetch categories that have products from a specific manufacturer
    $categories = Category::whereHas('products', function ($query) use ($manufacturerN) {
        $query->where('Manufacturer', $manufacturerN);
    })->with(['subcategories' => function ($query) use ($manufacturerN) {
        $query->whereHas('products', function ($subQuery) use ($manufacturerN) {
            $subQuery->where('Manufacturer', $manufacturerN);
        });
    }, 'products' => function ($query) use ($manufacturerN) {
        // Optionally load products here if needed for the view
        $query->where('Manufacturer', $manufacturerN);
    }])->get();

    // Handle the case where no categories are found
    if ($categories->isEmpty()) {
        return redirect()->back()->with('error', 'No categories found for the selected manufacturer.');
    }

    return view('categories.show', compact('categories'));
}


    public function adminProducts()
        {
            $products = Product::with('subCategory')->get(); // Eager load the subcategory relationship
            return view('includes.admin.products', compact('products'));  // Points to resources/views/includes/admin/products.blade.php
        }

    public function create()
    {
        $manufacturers = Manufacturer::all(); // Assuming you have a Manufacturer model
        $subcategories = SubCategory::all(); // Assuming you have a Category model
        return view('includes.admin.products.create', compact( 'manufacturers', 'subcategories'));
    }


public function importExcel(Request $request)
{
    $request->validate([
        'excel_file' => 'required|file|mimes:xlsx,xls',
    ]);

    ini_set('max_execution_time', 600);
    ini_set('memory_limit', '-1');

    $filePath = $request->file('excel_file')->getRealPath();
    $reader = IOFactory::createReaderForFile($filePath);
    $reader->setReadDataOnly(true);
    $spreadsheet = $reader->load($filePath);

    $sheet = $spreadsheet->getSheetByName('Sheet1');
    $codesSheet = $spreadsheet->getSheetByName('Codes');

    // ✅ Build individual maps for subcategories and manufacturers
    $subcatMap = [];
    $manufMap = [];

    foreach ($codesSheet->toArray() as $row) {
        if (!empty($row[0]) && !empty($row[1])) {
            $subcatMap[strtolower(trim($row[0]))] = $row[1];
        }
        if (!empty($row[2]) && !empty($row[3])) {
            $manufMap[strtolower(trim($row[2]))] = $row[3];
        }
    }

    // ✅ Read headers
    $headerRow = 5;
    $rawHeaders = $sheet->rangeToArray("A{$headerRow}:Z{$headerRow}")[0];
    $normalizedHeaders = array_map(fn($h) => strtolower(trim($h)), $rawHeaders);
    Log::info("📋 Headers from Excel: ", $normalizedHeaders);

    // ✅ Process rows
    $rowIterator = $sheet->getRowIterator($headerRow + 1);

    foreach ($rowIterator as $row) {
        $rowIndex = $row->getRowIndex();
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(true);

        $rowData = [];
        foreach ($cellIterator as $cell) {
            $columnIndex = Coordinate::columnIndexFromString($cell->getColumn()) - 1;
            $key = $normalizedHeaders[$columnIndex] ?? "col_{$columnIndex}";
            $rowData[$key] = $cell->getValue();
        }

        if (collect($rowData)->filter()->isEmpty()) {
            continue;
        }

        Log::debug("📦 Processing row {$rowIndex}", $rowData);

        // Validation
        $errors = [];
        $sku = trim($rowData['part number'] ?? '');
        if (!$sku) $errors[] = "Missing Part Number (SKU)";

        $subcatName = strtolower(trim($rowData['subcategory'] ?? ''));
        $manufName = strtolower(trim( $rowData['manufacturer'] ?? ''));

        // Optional aliasing
        $manufacturerAliases = [
            'tvs' => 'tvs',
            'dianaa' => 'dianaa fasteners',
        ];
        if (isset($manufacturerAliases[$manufName])) {
            $manufName = $manufacturerAliases[$manufName];
        }

        // Lookup IDs from maps
        $subcatId = $subcatMap[$subcatName] ?? null;
        $manufId = $manufMap[$manufName] ?? null;

        if (!$subcatName || !$subcatId) $errors[] = "Missing or unmapped Subcategory";
        if (!$manufName || !$manufId) $errors[] = "Missing or unmapped Manufacturer";

        if (!empty($errors)) {
            Log::warning("⚠️ Row {$rowIndex} skipped: " . implode('; ', $errors));
            continue;
        }
        Log::debug("🔍 Trying to resolve manufacturer '{$manufName}' and subcategory '{$subcatName}'");
        Log::debug("📌 Manufacturer keys available: ", array_keys($manufMap));

        // Final product data
        $productData = [
            'sku' => $sku,
            'slno' => trim($rowData['sl no.'] ?? ''),
            'description' => trim($rowData['item description'] ?? ''),
            'chapterID' => trim($rowData['chapter id'] ?? ''),
            'metric' => trim($rowData['metric or inches'] ?? ''),
            'ManufacturerID' => $manufId,
            'SubCategoryID' => $subcatId,
            'standardISO' => trim($rowData['std reference (iso / din)'] ?? ''),
            'grade' => trim($rowData['grade'] ?? ''),
            'threadType' => trim($rowData['full thread or half thread'] ?? ''),
            'standardType' => trim($rowData['unc / unf / bsf / bsw'] ?? ''),
            'size' => trim($rowData['thread size'] ?? ''),
            'color' => trim($rowData['colour'] ?? ''),
            'length' => trim($rowData['length'] ?? ''),
            'pitch' => $rowData['pitch'] ?? 0.0,
            'pitchType' => $rowData['pitch type'] ?? null,
            'point' => $rowData['cone/cup/flat points'] ?? null,
            'salePrice' => $rowData['list price'] ?? null,
            'discount' => isset($rowData['discount']) 
                ? (float) str_replace('%', '', $rowData['discount']) 
                : null,
            'moq' => $rowData['moq'] ?? null,
            'weight' => $rowData['weight'] ?? null,
            'quantity' => $rowData['quantity'] ?? 0,
            'basePrice' => $rowData['after discount'] ?? 0,
            'vendorPrice' => $rowData['vendor price'] ?? 0,
        ];

        \App\Models\Product::updateOrCreate(['sku' => $sku], $productData);
        Log::info("✅ Row {$rowIndex} imported successfully with SKU: {$sku}");
    }

    Log::info("✅ Excel import completed.");
    return redirect()->back()->with('success', 'Excel import completed successfully.');
}



    public function edit($id)
    {
        $manufacturers = Manufacturer::all(); // Assuming you have a Manufacturer model
        $subcategories = SubCategory::all(); // Assuming you have a Category model
        $product = Product::findOrFail($id);
        return view('includes.admin.products.edit', compact('product','manufacturers', 'subcategories'));
    }

    public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $rules = [
        'slno' => 'required|string|max:255',
        'sku' => 'required|string|max:50|unique:products,sku,' . $id . ',ProductID',
        'description' => 'required|string',
        'salePrice' => 'required|numeric',
        'vendorPrice' => 'required|numeric',
        'basePrice' => 'required|numeric',
        'discount' => 'nullable|numeric',
        'moq' => 'nullable|integer',
        'chapterID' => 'nullable|string',
        'SubCategoryID' => 'required|exists:sub_categories,SubCategoryID',
        'ManufacturerID' => 'required|exists:manufacturers,ManufacturerID',
        'standardISO' => 'nullable|string',
        'grade' => 'nullable|string',
        'size' => 'nullable|string',
        'threadType' => 'nullable|string',
        'color' => 'nullable|string',
        'metric' => 'nullable|string',
        'type' => 'required|string',
        'standardType' => 'nullable|string',
        'point' => 'nullable|string',
        'pitch' => 'nullable|numeric',
        'pitchType' => 'nullable|string',
        'length' => 'nullable|string',
        'weight' => 'nullable|numeric',
        'quantity' => 'required|integer',
        'image_path.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'ManufacturerID' => 'required|integer',
        'SubCategoryID' => 'required|integer',
    ];

    // Run validation
    $validator = Validator::make($request->all(), $rules);

    // Check for validation failure
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    // Get validated data
    $data = $validator->validated();

    // Log received data
    \Log::debug('Received update data:', $data);

    // Update the product with validated data
    $product->update($data);

    // Process the uploaded files, update only if new files are provided
    if ($request->hasFile('image_path')) {
        $imagePaths = [];
        foreach ($request->file('image_path') as $index => $file) {
            // Store the new image and collect their paths
            $path = $file->store('products', 'public');
            $imagePaths['image_' . ($index + 1)] = $path;

            \Log::debug('Updated image path:', ['key' => 'image_' . ($index + 1), 'path' => $path]);
        }

        $product->image_paths = json_encode($imagePaths);
        \Log::debug('Updated Image Paths:', ['paths' => $product->image_paths]);

        // Update main product image if it exists
        if (isset($imagePaths['image_1'])) {
            $product->product_image = $imagePaths['image_1'];
            \Log::debug('Main Product Image Path:', ['product_image' => $product->product_image]);
        }
    }

    // Attempt to save the updates to the database
    try {
        $product->save();
        \Log::info('Product saved successfully', ['id' => $product->ProductID]);
    } catch (\Exception $e) {
        \Log::error('Failed to save product', [
            'error' => $e->getMessage(),
            'data' => $data
        ]);
        return redirect()->back()->withErrors('Failed to save product.');
    }

    // Redirect with a success message
    return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
}


    public function store(Request $request)
{
    $rules = [
        'slno' => 'required|string|max:255',
        'sku' => 'required|string|max:50|unique:products,sku',
        'description' => 'required|string',
        'salePrice' => 'required|numeric',
        'vendorPrice' => 'required|numeric',
        'basePrice' => 'required|numeric',
        'discount' => 'nullable|numeric',
        'moq' => 'nullable|integer',
        'chapterID' => 'nullable|string',
        // 'SubCategoryID' => 'required|exists:sub_categories,SubCategoryID',
        // 'ManufacturerID' => 'required|exists:manufacturers,ManufacturerID',
        'standardISO' => 'nullable|string',
        'grade' => 'nullable|string',
        'size' => 'nullable|string',
        'threadType' => 'nullable|string',
        'color' => 'nullable|string',
        'metric' => 'nullable|string',
        'type' => 'required|string',
        'standardType' => 'nullable|string',
        'point' => 'nullable|string',
        'pitch' => 'nullable|numeric',
        'pitchType' => 'nullable|string',
        'length' => 'nullable|string',
        'weight' => 'nullable|numeric',
        'quantity' => 'required|integer',
        'image_path.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'ManufacturerID' => 'required|integer',
        'SubCategoryID' => 'required|integer',
    ];
    // Run validation
    $validator = Validator::make($request->all(), $rules);

    // Check for validation failure
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    // Get validated data
    $data = $validator->validated();
    
    \Log::debug('Received data:', $data);


    // Create a new product instance and assign validated data
    $product = new Product($data);

    // Process the uploaded files
    if ($request->hasFile('image_path')) {
        $imagePaths = [];
        foreach ($request->file('image_path') as $index => $file) {
            // Store the image and collect their paths
            $path = $file->store('products', 'public');
            $imagePaths['image_' . ($index + 1)] = $path;

            \Log::debug('Stored image path:', ['key' => 'image_' . ($index + 1), 'path' => $path]);
        }

        $product->image_paths = json_encode($imagePaths);
        \Log::debug('Encoded Image Paths:', ['paths' => $product->image_paths]);

        // Store image_1 as the main product image if it exists
        if (isset($imagePaths['image_1'])) {
            $product->product_image = $imagePaths['image_1'];  // Directly store the path without replacing characters
            \Log::debug('Main Product Image Path:', ['product_image' => $product->product_image]);
        }

        \Log::debug('Encoded Image Paths:', ['paths' => $product->image_paths]);
    }
    // Attempt to save the product to the database
    try {
        $product->save();
        \Log::info('Product saved successfully', ['id' => $product->ProductID]);
    } catch (\Exception $e) {
        \Log::error('Failed to save product', [
            'error' => $e->getMessage(),
            'data' => $data
        ]);
        return redirect()->back()->withErrors('Failed to save product.');
    }

    // Redirect with a success message
    return redirect()->route('admin.products')->with('success', 'Product added successfully!');
}

    public function destroy($id)
    {
       
            $product = Product::findOrFail($id);  // Find the product by ID
            $product->delete();  // Delete the product

            // Redirect with success message
            return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
        
    }

    public function fetchFilters()
{
    $brands = Product::select('Manufacturer as displayName')->distinct()->get();
    // \Log::info('Brands:', $brands->toArray());
    $materials = Product::select('Material as displayName')->distinct()->get();
    $sizes = Product::select('Size as displayName')->distinct()->get();
    $lengths = Product::select('Length as displayName')->distinct()->get();
    $standards = Product::select('Standard as displayName')->distinct()->get();
    $property = Product::select('Property_Class as displayName')->distinct()->get();
    $colors = Product::select('Color as displayName')->distinct()->get();

    return response()->json([
        'brands' => $brands,
        'materials' => $materials,
        'sizes' => $sizes,
        'lengths' => $lengths,
        'standards' => $standards,
        'colors' => $colors,
        'property'=> $property,
    ]);
}

public function applyFilters(Request $request, $subCategoryId)
{
    // Find the subcategory along with filtered products
    $subcategory = SubCategory::with(['products' => function($query) use ($request) {
        // Brand filter
        if ($request->has('brand-container')) {
            $query->whereIn('ManufacturerID', $request->input('brand-container'));
        }
        // Material filter
        if ($request->has('material-container')) {
            $query->whereIn('Material', $request->input('material-container'));
        }
        // Size filter
        if ($request->has('size-container')) {
            $query->whereIn('Size', $request->input('size-container'));
        }
        // Length filter
        if ($request->has('length-container')) {
            $query->whereIn('Length', $request->input('length-container'));
        }
        // Standard filter
        if ($request->has('standard-container')) {
            $query->whereIn('Standard', $request->input('standard-container'));
        }
        // Color filter
        if ($request->has('color-container')) {
            $query->whereIn('Color', $request->input('color-container'));
        }
        // Property Class filter
        if ($request->has('propertyClass-container')) {
            $query->whereIn('Property_Class', $request->input('propertyClass-container'));
        }
    }])->find($subCategoryId);

    if (!$subcategory) {
        return redirect()->back()->with('error', 'Subcategory not found');
    }

    // Apply sort order and pagination
    $sortOrder = $request->query('sort', 'best_match');
    switch ($sortOrder) {
        case 'price_low_high':
            $productsQuery = $subcategory->products()->orderBy('SalePrice', 'asc');
            break;
        case 'price_high_low':
            $productsQuery = $subcategory->products()->orderBy('SalePrice', 'desc');
            break;
        default:
            $productsQuery = $subcategory->products()->orderBy('Name', 'asc');
            break;
    }

    $perPage = $request->query('perPage', 12);
    $products = $productsQuery->paginate($perPage);

    // Determine the view type and ensure the correct partial is used
    $viewType = $request->query('view', 'grid');
    $viewName = 'partials.product_' . $viewType;

    if (!view()->exists($viewName)) {
        return redirect()->back()->with('error', 'Invalid view type specified');
    }

    // Render the product grid partial
    return view('pages.subcategory_product', compact('subcategory', 'products', 'viewType'));
}

}
