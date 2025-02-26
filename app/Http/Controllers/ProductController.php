<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


use App\Models\Category;
use App\Models\Product;
use App\Models\Manufacturer;
use App\Models\SubCategory;
\DB::enableQueryLog();

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
        $manufacturers = Manufacturer::all(); // Assuming you have a Manufacturer model
        $subcategories = SubCategory::all(); // Assuming you have a Category model
        return view('includes.admin.products.create', compact( 'manufacturers', 'subcategories'));
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
        // Validate request data, you might want to extract this as it's used in `store` as well
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'sku' => 'required|string|max:50',
        'salePrice' => 'required|numeric',
        'quantity' => 'required|integer',
        'product_image' => 'nullable|image|max:2048', // 2MB Max
        'size' => 'nullable|string',
        'length' => 'nullable|string',
        'property_class' => 'nullable|string',
        'standard' => 'nullable|string',
        'material' => 'nullable|string',
        'ManufacturerID' => 'nullable|integer',
        'SubCategoryID' => 'nullable|integer',
    ]);

    if ($request->hasFile('product_image')) {
        // Check if there's an existing image and delete it if it exists
        if ($product->product_image && Storage::exists($product->product_image)) {
            Storage::delete($product->product_image);
        }

        // Store the new image and update the image path in the database
        $data['product_image'] = $request->file('product_image')->store('products', 'public');
    } else {
        // retain the old image
        $data['product_image'] = $product->product_image;
    }

    $product->update($data);
        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
    }

    public function store(Request $request)
    {
        // dd($request->all());
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'sku' => 'required|string|max:50',
        'salePrice' => 'required|numeric',
        'quantity' => 'required|integer',
        'product_image' => 'nullable|image|max:2048', // 2MB Max
        'size' => 'nullable|string',
        'length' => 'nullable|string',
        'property_class' => 'nullable|string',
        'standard' => 'nullable|string',
        'material' => 'nullable|string',
        'ManufacturerID' => 'nullable|integer',
        'SubCategoryID' => 'nullable|integer',
    ]);
    

   // Create a new product instance and save it
   $product = new Product($data);
   if ($request->hasFile('product_image')) {
       $product->product_image = $request->file('product_image')->store('products', 'public');
   }
    $product->save();

    \Log::info('Database Query:', \DB::getQueryLog()); // Log the query log after the product is saved

    return redirect()->route('admin.products')->with('success', 'Product added successfully!');
    }

    public function destroy($id)
    {
       
            $product = Product::findOrFail($id);  // Find the product by ID
            $product->delete();  // Delete the product

            // Redirect with success message
            return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
        
    }
}
