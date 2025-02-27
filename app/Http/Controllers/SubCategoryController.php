<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;

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
    
        $subcategory = SubCategory::with(['products' => function($query) use ($request, $sortOrder) {
            // Apply manufacturer ID filter if provided
            if ($request->filled('manufacturer')) {
                $manufacturerIds = is_array($request->manufacturer) ? $request->manufacturer : [$request->manufacturer];
                $query->whereIn('ManufacturerID', $manufacturerIds);
            }
    
            // Apply other filters based on request inputs, like material, etc.
            if ($request->filled('material')) {
                $query->whereIn('material', (array) $request->material);
            }
    
            // Apply sorting
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
        }])->findOrFail($subCategoryId);
        
        $products = $subcategory->products;
        return view('pages.subcategory_product', compact('subcategory', 'products', 'viewType'));
    }

    public function filter(Request $request, $subCategoryId) {
        $query = SubCategory::with(['products' => function($q) use ($request) {
            if ($request->filled('availability')) {
                // Add availability filter logic
            }
            if ($request->filled('manufacturer')) {
                $q->whereIn('manufacturer', $request->manufacturer);
            }
            if ($request->filled('material')) {
                $q->whereIn('material', $request->material);
            }
        }])->findOrFail($subCategoryId);
    
        $products = $query->products;
    
        return response()->json([
            'html' => view('partials.product_grid', compact('products'))->render()
        ]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = $request->input('perPage', 10); // Default to 10 items per page

        $subcategories = Subcategory::where('name', 'like', '%' . $search . '%')
                                    ->orderBy('name') // Alphabetical order
                                    ->paginate($perPage);
        return view('includes.admin.subcategories', compact('subcategories'));
    }

    public function create()
    {
        return view('admin.subcategories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB Max
        ]);

        $subcategory = new Subcategory($validatedData);
        if ($request->hasFile('subcategory_image')) {
            $imagePath = $request->file('subcategory_image')->store('subcategories', 'public');
            $subcategory->Image = $imagePath; // Ensure your database column is named `image`
        }

        $subcategory->save();
        return redirect()->route('admin.subcategories')->with('success', 'Subcategory created successfully.');
    }

    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all(); // Fetch all categories for dropdown
        return view('includes.admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, Subcategory $subcategory)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'subcategory_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Allowing for common image formats
    ]);

    // Check if a new image file was uploaded
    if ($request->hasFile('subcategory_image')) {
        // Check if there's an existing image and delete it from storage if it exists
        if ($subcategory->image && Storage::disk('public')->exists($subcategory->Image)) {
            Storage::disk('public')->delete($subcategory->Image);
        }

        // Store the new image in the 'subcategories' directory within public storage
        $imagePath = $request->file('subcategory_image')->store('subcategories', 'public');
        // Update the image path in the subcategory instance
        $subcategory->Image = $imagePath;
    }

    // Update other data fields
    $subcategory->Name = $data['name'];
    $subcategory->CategoryID = $data['category_id'];
    $subcategory->save(); // Save the changes explicitly

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
