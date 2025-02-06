<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

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
}
