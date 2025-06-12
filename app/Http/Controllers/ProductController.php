<?php

namespace App\Http\Controllers;
use App\Models\ProductColorVariant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
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
    public function brandCategories($brand_id)
{
    // Fetch categories where at least one subcategory has products from the given ManufacturerID
    $categories = Category::with(['subcategories' => function ($subQuery) use ($brand_id) {
        $subQuery->whereHas('products', function ($productQuery) use ($brand_id) {
            $productQuery->where('ManufacturerID', $brand_id);
        });
    }])
    ->whereHas('subcategories.products', function ($query) use ($brand_id) {
        $query->where('ManufacturerID', $brand_id);
    })
    ->get()
    // Ensure empty subcategory collections are excluded (in case of empty eager loading)
    ->filter(function ($category) {
        return $category->subcategories->isNotEmpty();
    })
    ->values();

    $manufacturer = Manufacturer::find($brand_id);

    return view('pages.products_main', [
        'categories' => $categories,
        'manufacturer' => $manufacturer,
        'brand_id' => $brand_id
    ]);
}


    public function showByProducts($ProductID)
{
    $product = Product::with(['colorVariants'])->findOrFail($ProductID); // include color variants
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
    Log::info("🔧 ImportExcel route hit.");
    $request->validate([
        'excel_file' => 'required|file|mimes:xlsx,xls',
    ]);

    ini_set('max_execution_time', 600);
    ini_set('memory_limit', '-1');

    $uploaded = $request->file('excel_file');
    $storedPath = $uploaded->storeAs('temp', uniqid() . '.xlsx', 'local');
    $fullPath = storage_path('app/' . $storedPath);

    if (!file_exists($fullPath)) {
        Log::error("❌ File not found at: $fullPath");
        return redirect()->back()->withErrors('Upload failed: file not found.');
    }

    try {
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($fullPath);
    } catch (\Exception $e) {
        Log::error("❌ Failed to load Excel: " . $e->getMessage());
        return redirect()->back()->withErrors("Upload failed: Excel format error.");
    }

    $sheetNames = $spreadsheet->getSheetNames();
    Log::info("📑 Sheet names available:", $sheetNames);

    $dataSheet = $spreadsheet->getSheetByName('Data');
    $codesSheet = $spreadsheet->getSheetByName('Codes');

    if (!$dataSheet || !$codesSheet) {
        Log::error("❌ Required sheets not found.");
        return redirect()->back()->withErrors("Data or Codes sheet not found.");
    }

    $dataRows = $dataSheet->toArray(null, true, true, true);
    Log::info("🔎 Row keys in Data sheet: " . json_encode(array_keys($dataRows)));
    Log::info("🧾 First 3 rows preview:", array_slice($dataRows, 0, 3));

    $codesRows = $codesSheet->toArray(null, true, true, true);

    // ✅ Detect header row dynamically
    $headerRow = null;
    $startIndex = null;

    foreach ($dataRows as $rowNum => $row) {
        if (!empty(array_filter($row))) {
            $headerRow = array_map(fn($h) => strtolower(trim($h)), $row);
            $startIndex = $rowNum + 1;
            break;
        }
    }

    if (!$headerRow || $startIndex === null || count($dataRows) <= $startIndex) {
        Log::warning("❌ No valid data rows found after header.");
        return redirect()->back()->withErrors("Excel file does not contain data rows after the header.");
    }

    Log::info("📋 Headers from Excel", $headerRow);

    // ✅ Build lookup maps from Codes sheet
    $subcatMap = [];
    $manufMap = [];
    foreach ($codesRows as $row) {
        if (!empty($row['A']) && !empty($row['B'])) {
            $subcatMap[strtolower(trim($row['A']))] = $row['B'];
        }
        if (!empty($row['C']) && !empty($row['D'])) {
            $manufMap[strtolower(trim($row['C']))] = $row['D'];
        }
    }

    // ✅ Iterate data rows
    foreach ($dataRows as $i => $row) {
        if ($i < $startIndex) continue;

        $rowIndex = $i + 1;
        $rowData = [];

        foreach ($headerRow as $col => $fieldName) {
            $rowData[$fieldName] = $row[$col] ?? null;
        }

        if (empty(trim($rowData['part number'] ?? '')) &&
            empty(trim($rowData['subcategory'] ?? '')) &&
            empty(trim($rowData['manufacturer'] ?? ''))) {
            continue;
        }

        $sku = trim($rowData['part number'] ?? '');
        $subcatName = strtolower(trim($rowData['subcategory'] ?? ''));
        $manufName = strtolower(trim($rowData['manufacturer'] ?? ''));

        $manufacturerAliases = ['tvs' => 'tvs', 'dianaa' => 'dianaa fasteners'];
        $manufName = $manufacturerAliases[$manufName] ?? $manufName;

        $subcatId = $subcatMap[$subcatName] ?? null;
        $manufId = $manufMap[$manufName] ?? null;

        $errors = [];
        if (!$sku) $errors[] = "Missing SKU";
        if (!$subcatId) $errors[] = "Subcategory not mapped";
        if (!$manufId) $errors[] = "Manufacturer not mapped";

        if (!empty($errors)) {
            Log::warning("⚠️ Row {$rowIndex} skipped: " . implode('; ', $errors));
            continue;
        }

        // ✅ Image paths
        $imagePathsJson = [];
        $firstImage = null;
        $imageRaw = trim($rowData['image paths'] ?? '');
        if (!empty($imageRaw)) {
            $imageNames = array_map('trim', explode(',', $imageRaw));
            foreach ($imageNames as $k => $imageName) {
                if ($imageName !== '') {
                    $key = 'image_' . ($k + 1);
                    $imagePathsJson[$key] = 'products/' . $imageName;
                    if ($k === 0) $firstImage = 'products/' . $imageName;
                }
            }
        }

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
            // 'salePrice' => $rowData['list price'] ?? null,
            'discount' => isset($rowData['discount'])
                ? (
                    is_numeric($rowData['discount']) && $rowData['discount'] < 1
                        ? (float) $rowData['discount'] * 100
                        : (float) str_replace('%', '', $rowData['discount'])
                )
                : null,
            'moq' => $rowData['moq'] ?? 0,
            'weight' => $rowData['weight'] ?? 0,
            'quantity' => $rowData['quantity'] ?? 0,
            'type' => $rowData['featured / best sellers / new arrivals'] ?? null,
            'vendorDiscount' => isset($rowData['vendorDiscount'])
                ? (
                    is_numeric($rowData['vendorDiscount']) && $rowData['vendorDiscount'] < 1
                        ? (float) $rowData['vendorDiscount'] * 100
                        : (float) str_replace('%', '', $rowData['vendorDiscount'])
                )
                : null,
            'basePrice' => $rowData['after discount'] ?? 0,
            'vendorPrice' => $rowData['vendor price'] ?? 0,
            'image_paths' => json_encode($imagePathsJson),
            'product_image' => $firstImage,
        ];

        $product = Product::updateOrCreate(['sku' => $sku], $productData);

        // Clear existing variants for updated SKU
        ProductColorVariant::where('product_id', $product->ProductID)->delete();

        // Handle color variants
        $colorRaw = trim($rowData['colour variants'] ?? '');
        $priceRaw = trim($rowData['sale prices'] ?? '');

        $colors = array_map('trim', explode(',', $colorRaw));
        $prices = array_map('trim', explode(',', $priceRaw));

        if (count($colors) && count($colors) === count($prices)) {
            foreach ($colors as $index => $color) {
                $price = is_numeric($prices[$index]) ? (float) $prices[$index] : null;
                if ($color && $price !== null) {
                    ProductColorVariant::create([
                        'product_id' => $product->ProductID,
                        'color' => $color,
                        'sale_price' => $price,
                    ]);
                    Log::info("✅ Color variant added", [
                        'product_id' => $product->ProductID,
                        'color' => $color,
                        'sale_price' => $price,
                    ]);
                }
            }
        } else {
            Log::warning("⚠️ Mismatch or missing color variant data for SKU: {$sku}");
        }

        Log::info("✅ Imported SKU: {$sku}");
    }

    Log::info("✅ Excel import completed.");
    return redirect()->back()->with('success', 'Excel import completed successfully.');
}




public function edit($id)
{
    $manufacturers = Manufacturer::all();
    $subcategories = SubCategory::all();
    $product = Product::with('colorVariants')->findOrFail($id); // include variants

    return view('includes.admin.products.edit', compact('product', 'manufacturers', 'subcategories'));
}

public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $rules = [
        'slno' => 'required|string|max:255',
        'sku' => 'required|string|max:50|unique:products,sku,' . $id . ',ProductID',
        'description' => 'required|string',
        'salePrice' => 'nullable|numeric',
        'vendorPrice' => 'required|numeric',
        'basePrice' => 'nullable|numeric',
        'discount' => 'nullable|numeric',
        'vendorDiscount' => 'nullable|numeric',
        'moq' => 'nullable|integer',
        'chapterID' => 'nullable|string',
        'SubCategoryID' => 'required|exists:sub_categories,SubCategoryID',
        'ManufacturerID' => 'required|exists:manufacturers,ManufacturerID',
        'standardISO' => 'nullable|string',
        'grade' => 'nullable|string',
        'size' => 'nullable|string',
        'threadType' => 'nullable|string',
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
        'color_variants' => 'required|array',
        'color_variants.*.color' => 'required|string',
        'color_variants.*.sale_price' => 'required|numeric',
        'ManufacturerID' => 'required|integer',
        'SubCategoryID' => 'required|integer',
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    $data = $validator->validated();
    Log::debug('Received update data:', $data);

    DB::beginTransaction();
    try {
        $product->update($data);

        // Handle images if re-uploaded
        if ($request->hasFile('image_path')) {
            $imagePaths = [];
            foreach ($request->file('image_path') as $index => $file) {
                $path = $file->store('products', 'public');
                $imagePaths['image_' . ($index + 1)] = $path;
                Log::debug('Updated image path:', ['key' => 'image_' . ($index + 1), 'path' => $path]);
            }

            $product->image_paths = json_encode($imagePaths);

            if (isset($imagePaths['image_1'])) {
                $product->product_image = $imagePaths['image_1'];
            }
        }

        $product->save();
        Log::info('Product base info updated', ['id' => $product->ProductID]);

        // ✅ Handle Color Variants
        ProductColorVariant::where('product_id', $product->ProductID)->delete(); // remove old variants

        foreach ($data['color_variants'] as $variant) {
            ProductColorVariant::create([
                'product_id' => $product->ProductID,
                'color' => $variant['color'],
                'sale_price' => $variant['sale_price'],
            ]);
        }

        DB::commit();
        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Failed to update product', [
            'error' => $e->getMessage(),
            'data' => $data
        ]);
        return redirect()->back()->withErrors('Failed to update product.');
    }
}

public function store(Request $request)
{
    $rules = [
        'slno' => 'required|string|max:255',
        'sku' => 'required|string|max:50|unique:products,sku,' . $id . ',ProductID',
        'description' => 'required|string',
        'salePrice' => 'nullable|numeric',
        'vendorPrice' => 'required|numeric',
        'basePrice' => 'nullable|numeric',
        'discount' => 'nullable|numeric',
        'vendorDiscount' => 'nullable|numeric',
        'moq' => 'nullable|integer',
        'chapterID' => 'nullable|string',
        'SubCategoryID' => 'required|exists:sub_categories,SubCategoryID',
        'ManufacturerID' => 'required|exists:manufacturers,ManufacturerID',
        'standardISO' => 'nullable|string',
        'grade' => 'nullable|string',
        'size' => 'nullable|string',
        'threadType' => 'nullable|string',
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
        'color_variants' => 'required|array',
        'color_variants.*.color' => 'required|string',
        'color_variants.*.sale_price' => 'required|numeric',
        'ManufacturerID' => 'required|integer',
        'SubCategoryID' => 'required|integer',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    $data = $validator->validated();
    Log::debug('Received data:', $data);

    DB::beginTransaction();

    try {
        $product = new Product($data);

        // Handle images
        if ($request->hasFile('image_path')) {
            $imagePaths = [];

            foreach ($request->file('image_path') as $index => $file) {
                $path = $file->store('products', 'public');
                $imagePaths['image_' . ($index + 1)] = $path;
                Log::debug('Stored image path:', ['key' => 'image_' . ($index + 1), 'path' => $path]);
            }

            $product->image_paths = json_encode($imagePaths);

            if (isset($imagePaths['image_1'])) {
                $product->product_image = $imagePaths['image_1'];
                Log::debug('Main Product Image Path:', ['product_image' => $product->product_image]);
            }
        }

        $product->save();
        Log::info('Product saved successfully', ['id' => $product->ProductID]);

        // Save color variants to product_color_variants table
        foreach ($data['color_variants'] as $variant) {
            ProductColorVariant::create([
                'product_id' => $product->ProductID,
                'color' => $variant['color'],
                'sale_price' => $variant['sale_price'],
            ]);

            Log::info('Color variant added', [
                'product_id' => $product->ProductID,
                'color' => $variant['color'],
                'sale_price' => $variant['sale_price'],
            ]);
        }

        DB::commit();
        return redirect()->route('admin.products')->with('success', 'Product added successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Failed to save product', [
            'error' => $e->getMessage(),
            'data' => $data
        ]);
        return redirect()->back()->withErrors('Failed to save product.');
    }
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
