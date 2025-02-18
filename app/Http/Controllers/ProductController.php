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

public function adminProducts()
    {
        $products = Product::with('subCategory')->get(); // Eager load the subcategory relationship
        return view('includes.admin.products', compact('products'));  // Points to resources/views/includes/admin/products.blade.php
    }

    public function create()
    {
        // Prepare any data you need for the view, if necessary
        return view('admin.products.create');
    }
    
    public function showProducts($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
    }

}
