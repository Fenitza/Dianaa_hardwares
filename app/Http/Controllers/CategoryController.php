<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // $categories = Category::all(); // Fetch all categories
        // Log::info('Categories retrieved: ', $categories->toArray()); // Log the data
        // return view('home', ['categories' => $categories]); // Pass them to the home view

        $categories = Category::with('subcategories.products')->get();

        // Check if 'type' parameter is provided, otherwise default to 'Featured'
        $selectedType = $request->input('type', 'Featured'); // Default type
        $category = $request->input('category', 'Bolts'); // Default type

        $filteredProducts = collect(); // Initialize an empty collection

    // Example: Assuming you want to filter products by a certain condition
    foreach ($categories as $category) {
        foreach ($category->subcategories as $subcategory) {
            foreach ($subcategory->products as $product) {
                // Check if the product's type matches the selected type
                if (strtolower($product->type) === strtolower($selectedType)) {
                    $filteredProducts->push($product);
                }
            }
        }
    }

    Log::info('Received category: ' . $request->input('category'));
    Log::info('Received type: ' . $request->input('type'));

        // Filter products by selected type and pass to view
        // Assuming you're filtering products within the view or collecting them here
        return view('home', [
            'categories' => $categories,
            'selectedType' => $selectedType,
            'filteredProducts' => $filteredProducts
        ]);
    }

    public function showCategories() {
    $categories = Category::with(['subcategories' => function($query) {
        $query->with(['products' => function($query) {
            $query->take(6); // Adjust the number as needed
        }]); 
    }])->get();
    return view('home', compact('categories'));
}

    public function admin_index(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = $request->input('perPage', 10); // Default to 10 items per page
    
        $categories = Category::where('name', 'like', '%' . $search . '%')
                                ->orderBy('name') // Alphabetical order
                                ->paginate($perPage);
        // $categories = Category::all();
        return view('includes.admin.categories', compact('categories'));
    }

    public function create()
    {
        return view('includes.admin.categories.create');
    }

    public function store(Request $request)
{
    // Validate input data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category_image' => 'required|image|max:2048', // Validate image and set size limit
    ]);

    // Create a new category instance and assign validated data
    $category = new Category();
    $category->name = $validatedData['name'];
    $category->description = $validatedData['description'];

    // Handle the category image upload
    if ($request->hasFile('category_image')) {
        // Store the image in the 'categories' directory within the public storage
        $imagePath = $request->file('category_image')->store('categories', 'public');
        // Save the path of the image in the database
        $category->category_image = $imagePath;
    }

    // Save the category to the database
    $category->save();

    // Redirect with a success message
    return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
}


    public function edit(Category $category)
    {
        return view('includes.admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
{
    // Validate the incoming request data
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category_image' => 'required|image|max:2048', // 2MB Max
    ]);

    // Check if a new image file was uploaded
    if ($request->hasFile('category_image')) {
        // Check if there's an existing image and delete it from storage if it exists
        if ($category->category_image && Storage::disk('public')->exists($category->category_image)) {
            Storage::disk('public')->delete($category->category_image);
        }

        // Store the new image in the 'categories' directory within public storage
        $imagePath = $request->file('category_image')->store('categories', 'public');
        // Update the image path in the data array to be saved
        $data['category_image'] = $imagePath;
    } else {
        // No new image uploaded, retain the old image
        $data['category_image'] = $category->category_image;
    }

    // Update the category with the validated data
    $category->update($data);

    // Redirect back to the categories list with a success message
    return redirect()->route('admin.categories')->with('success', 'Category updated successfully.');
}


public function destroy(Category $category)
{
    if ($category->subcategories()->exists()) {
        return redirect()->route('admin.categories')
                         ->with('error', 'This category cannot be deleted because it has related subcategories.');
    }

    $category->delete();
    return redirect()->route('admin.categories')
                     ->with('success', 'Category deleted successfully.');
}
}
