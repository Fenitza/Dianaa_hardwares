<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
\DB::enableQueryLog();
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log;

class SubCategoryController extends Controller
{

    public function show(Request $request, $subCategoryId) {
        \Log::info('Received subCategoryId: ', ['subCategoryId' => $subCategoryId]);
    \Log::info('Request Data: ', $request->all());
    // Validate sort and view inputs
   
    $sortOrder = $request->query('sort', 'best_match');
    $validSortOptions = ['best_match', 'price_low_high', 'price_high_low'];
    if (!in_array($sortOrder, $validSortOptions)) {
        $sortOrder = 'best_match'; // Default if invalid sort order provided
    }

    $viewType = $request->query('view', 'grid');
    $validViewTypes = ['grid', 'list', 'catalog'];
    if (!in_array($viewType, $validViewTypes)) {
        $viewType = 'grid'; // Default if invalid view type provided
    }

    $perPage = $request->query('perPage', 12); // Set default per page or get from request

    $subcategory = SubCategory::findOrFail($subCategoryId);

    // Build the query on the products related to the subcategory
    $productsQuery = $subcategory->products();

    // Apply material filter if present
    // Apply brand filter if present
    if ($request->has('brand_id')) {
        $brandId = $request->query('brand_id');
        $productsQuery->where('ManufacturerID', $brandId);
        \Log::info('Filtering products by ManufacturerID:', ['brand_id' => $brandId]);
    }

    

    // Execute the query with filters applied
    // $products = $productsQuery->get(); // Use get() for debugging, replace with paginate() if needed

    // Log the query to see what SQL is executed
    $lastQuery = \DB::getQueryLog();
    \Log::info('Final SQL executed: ', end($lastQuery)); // Log the last executed SQL

    // Apply sorting
    switch ($sortOrder) {
        case 'price_low_high':
            $productsQuery->orderBy('SalePrice', 'asc');
            break;
        case 'price_high_low':
            $productsQuery->orderBy('SalePrice', 'desc');
            break;
        default:
            $productsQuery->orderBy('Name', 'asc');
            break;
    }

    // Execute the query with pagination
    $products = $productsQuery->paginate($request->query('perPage', 12));
    // Optional: Log the executed query for debugging
\DB::listen(function($query) {
    \Log::info("Query executed: ".$query->sql);
    \Log::info("Bindings: ", $query->bindings);
    });

    return view('pages.subcategory_product', compact('subcategory', 'products', 'viewType'));
}

public function getFilters(Request $request)
{
    $subCategoryId = $request->query('subcategory_id');

    if (!$subCategoryId) {
        return response()->json(['error' => 'Subcategory ID is required'], 400);
    }

    $products = Product::where('SubCategoryID', $subCategoryId)->get();

    return response()->json([
        'brand' => $products->pluck('ManufacturerID')->unique()->filter()->values()->map(function ($id) {
    $manufacturer = Manufacturer::where('ManufacturerID', $id)->first();
    return $manufacturer
        ? ['value' => $manufacturer->ManufacturerID, 'displayName' => $manufacturer->Name]
        : ['value' => $id, 'displayName' => "Unknown ID: $id"];
}),


        'size' => $products->pluck('size')->unique()->filter()->values()->map(fn($v) => ['displayName' => $v]),
        'length' => $products->pluck('length')->unique()->filter()->values()->map(fn($v) => ['displayName' => $v]),
        'grade' => $products->pluck('grade')->unique()->filter()->values()->map(fn($v) => ['displayName' => $v]),
        'color' => $products->pluck('color')->unique()->filter()->values()->map(fn($v) => ['displayName' => $v]),
        'pitch' => $products->pluck('pitch')->unique()->filter()->values()->map(fn($v) => ['displayName' => $v]),
        'weight' => $products->pluck('weight')->unique()->filter()->values()->map(fn($v) => ['displayName' => $v]),
        'type' => $products->pluck('type')->unique()->filter()->values()->map(fn($v) => ['displayName' => $v]), // FT/HT
        'metric' => $products->pluck('metric')->unique()->filter()->values()->map(fn($v) => ['displayName' => $v]), // MM/Inches
        'threadtype' => $products->pluck('threadType')->unique()->filter()->values()->map(fn($v) => ['displayName' => $v]), // UNC/UNF...
        'point' => $products->pluck('point')->unique()->filter()->values()->map(fn($v) => ['displayName' => $v]), // Cone/Cup/Flat
        'pitchtype' => $products->pluck('pitchType')->unique()->filter()->values()->map(fn($v) => ['displayName' => $v]),
    ]);
}

public function applyFilters(Request $request, $subCategoryId)
{
    // Step 1: Base Query
    $productsQuery = Product::where('SubCategoryID', $subCategoryId);

    // Step 2: Filter Mapping
    $filterFields = [
        'brand' => 'ManufacturerID',
        'size' => 'Size',
        'length' => 'Length',
        'grade' => 'Grade',
        'color' => 'Color',
        'pitch' => 'Pitch',
        'weight' => 'Weight',
        'type' => 'Type',
        'metric' => 'Metric',
        'threadtype' => 'ThreadType',
        'point' => 'Point',
        'pitchtype' => 'PitchType',
    ];

    foreach ($filterFields as $key => $column) {
        if ($request->has($key)) {
            $values = $request->input($key);

            // Log input
            \Log::info("Filter applied", [
                'key' => $key,
                'values' => $values
            ]);

            if (!empty($values)) {
                $values = is_array($values) ? $values : explode(',', $values);
                $productsQuery->whereIn($column, $values);
            }
        }
    }

    // Step 3: Sorting
    $sortOrder = $request->query('sort', 'best_match');
    switch ($sortOrder) {
        case 'price_low_high':
            $productsQuery->orderBy('SalePrice', 'asc');
            break;
        case 'price_high_low':
            $productsQuery->orderBy('SalePrice', 'desc');
            break;
        default:
            $productsQuery->orderBy('Name', 'asc');
            break;
    }

    // Step 4: Pagination
    $perPage = $request->query('perPage', 12);
    $products = $productsQuery->paginate($perPage)->appends($request->query());

    // Step 5: SubCategory Info
    $subcategory = SubCategory::findOrFail($subCategoryId);

    // Step 6: View Type
    $viewType = $request->query('view', 'grid');
    $viewName = 'partials.product_' . $viewType;

    if (!view()->exists($viewName)) {
        return redirect()->back()->with('error', 'Invalid view type specified');
    }

    // Optional: Log final query (for debugging)
    \Log::info('Final query', [
        'sql' => $productsQuery->toSql(),
        'bindings' => $productsQuery->getBindings()
    ]);

    // Step 7: Return View
    return view('pages.subcategory_product', compact('subcategory', 'products', 'viewType'));
}



public function getProducts(Request $request, $id = null)
{
    $type = $request->query('type'); // Get the type from query parameters

    // If no ID is provided, automatically determine the first subcategory of the first category
    if (is_null($id)) {
        $firstCategory = Category::with(['subcategories' => function($query) use ($type) {
            // Optionally filter subcategories that have at least one product of the specified type
            if ($type) {
                $query->whereHas('products', function($q) use ($type) {
                    $q->where('type', $type);
                });
            }
        }])->first();

        if ($firstCategory && $firstCategory->subcategories->count() > 0) {
            $id = $firstCategory->subcategories->first()->SubCategoryID;
        } else {
            return response()->json(['error' => 'No products available'], 404); // No subcategories or products of the specified type found
        }
    }

    $subcategory = Subcategory::find($id);
    if (!$subcategory) {
        return response()->json(['error' => 'Subcategory Products not found'], 404);
    }

    // Construct the products query based on the type
    $productsQuery = $subcategory->products(); // Assuming 'products' is a relationship defined in Subcategory model
    if ($type) {
        $productsQuery->where('type', $type);
    }
 
    $products = $productsQuery->take(6)->get();

    return response()->json($products);
}

    
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = $request->input('perPage', 10); // Default to 10 items per page

        $subcategories = Subcategory::where('name', 'like', '%' . $search . '%')
                                    ->orderBy('name') // Alphabetical order
                                    ->simplePaginate($perPage);
        return view('includes.admin.subcategories', compact('subcategories'));
    }

    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('includes.admin.subcategories.create',compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,CategoryID',
            'subcategory_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);
        // dd($request->all(), $validatedData);

        $subcategory = new Subcategory();
        $subcategory->fill($validatedData);
        $subcategory->Name = $validatedData['name'];
        $subcategory->Description = $validatedData['description'];
        $subcategory->CategoryID = $validatedData['category_id'];
        if ($request->hasFile('subcategory_image')) {
            $imagePath = $request->file('subcategory_image')->store('subcategories', 'public');
            $subcategory->Image = $imagePath; // Ensure your database column is named `image`
        }

        $subcategory->save();
        // Log::info('Received data:', $request->all());
        return redirect()->route('admin.subcategories')->with('success', 'Subcategory created successfully.');
    }

    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all(); // Fetch all categories for dropdown
        return view('includes.admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, Subcategory $subcategory)
{
    
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category_id' => 'required|exists:categories,CategoryID', // Ensure it references CategoryID correctly
        'subcategory_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    ]);

    // Fill the subcategory with validated data
    $subcategory->fill($validatedData);
    $subcategory->Name = $validatedData['name'];
    $subcategory->Description = $validatedData['description'];

    // Handle image upload if there's one
    if ($request->hasFile('subcategory_image')) {
        // Check if there's an existing image and delete it from storage if it exists
        if ($subcategory->Image && Storage::disk('public')->exists($subcategory->Image)) {
            Storage::disk('public')->delete($subcategory->Image);
        }
        // Store the new image in the 'subcategories' directory within public storage
        $imagePath = $request->file('subcategory_image')->store('subcategories', 'public');
        $subcategory->Image = $imagePath; // Ensure the database column is named `Image`
    }

    // Save the changes to the database
    $subcategory->save();

    // Redirect back to the subcategories list with a success message
    return redirect()->route('admin.subcategories')->with('success', 'Subcategory updated successfully.');
}

    public function destroy(Subcategory $subcategory)
    {
        if ($subcategory->products()->exists()) {
            return redirect()->route('admin.subcategories')->with('error', 'This subcategory cannot be deleted because it has related products.');
        }

        $subcategory->delete();
        return redirect()->route('admin.subcategories')->with('success', 'Subcategory deleted successfully.');
    }
}
