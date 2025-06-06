<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;
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

    // Apply material filter if present
    if ($request->has('material')) {
        $materials = $request->query('material');
        $materials = is_array($materials) ? $materials : explode(',', $materials);
        $productsQuery->whereIn('Material', $materials);
        \Log::info('Applying material filter with values:', $materials);
    }

    // Apply size filter if present
    if ($request->has('size')) {
        $sizes = $request->query('size');
        $sizes = is_array($sizes) ? $sizes : explode(',', $sizes);
        $productsQuery->whereIn('Size', $sizes);
        \Log::info('Applying size filter with values:', $sizes);
    }

    // Apply length filter if present
    if ($request->has('length')) {
        $lengths = $request->query('length');
        $lengths = is_array($lengths) ? $lengths : explode(',', $lengths);
        $productsQuery->whereIn('Length', $lengths);
        \Log::info('Applying length filter with values:', $lengths);
    }

    // Apply standard filter if present
    if ($request->has('standard')) {
        $standards = $request->query('standard');
        $standards = is_array($standards) ? $standards : explode(',', $standards);
        $productsQuery->whereIn('Standard', $standards);
        \Log::info('Applying standard filter with values:', $standards);
    }

    // Apply color filter if present
    if ($request->has('color')) {
        $colors = $request->query('color');
        $colors = is_array($colors) ? $colors : explode(',', $colors);
        $productsQuery->whereIn('Color', $colors);
        \Log::info('Applying color filter with values:', $colors);
    }

    // Apply property class filter if present
    if ($request->has('propertyClass')) {
        $propertyClasses = $request->query('propertyClass');
        $propertyClasses = is_array($propertyClasses) ? $propertyClasses : explode(',', $propertyClasses);
        $productsQuery->whereIn('Property_Class', $propertyClasses);
        \Log::info('Applying property class filter with values:', $propertyClasses);
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
