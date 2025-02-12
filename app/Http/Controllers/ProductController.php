<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;

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
    return view('pages.product_details', compact('product'));
}

public function showByManufacturer($manufacturerId)
{
    $categories = Category::whereHas('products', function ($query) use ($manufacturerId) {
        $query->where('manufacturer_id', $manufacturerId);
    })->with(['subcategories' => function ($query) use ($manufacturerId) {
        $query->whereHas('products', function ($subQuery) use ($manufacturerId) {
            $subQuery->where('manufacturer_id', $manufacturerId);
        });
    }])->get();

    return view('categories.show', compact('categories'));
}


}
