<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class SubCategoryController extends Controller
{
    public function show(Request $request, $subCategoryId) {
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

    $perPage = $request->query('perPage', 1); // Set default per page or get from request

    $subcategory = SubCategory::findOrFail($subCategoryId);
    $products = $subcategory->products()->with('manufacturer')->when($request->filled('manufacturer'), function ($query) use ($request) {
        $manufacturerIds = is_array($request->manufacturer) ? $request->manufacturer : [$request->manufacturer];
        $query->whereIn('ManufacturerID', $manufacturerIds);
    })->when($request->filled('material'), function ($query) use ($request) {
        $query->whereIn('material', (array) $request->material);
    })->when($sortOrder, function ($query) use ($sortOrder) {
        switch ($sortOrder) {
            case 'price_low_high':
                $query->orderBy('SalePrice', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('SalePrice', 'desc');
                break;
            default:
                $query->orderBy('Name', 'asc'); // Treats 'best_match' as a default case
                break;
        }
    })->paginate($perPage);

    return view('pages.subcategory_product', compact('subcategory', 'products', 'viewType'));
}

    
    public function getProducts($id) {
    $products = Subcategory::find($id)->products()->take(6)->get(); // Ensure to adjust according to your needs
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
