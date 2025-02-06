<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function show($subCategoryId) {
        $subcategory = Subcategory::with('products')->findOrFail($subCategoryId);
        $products = $subcategory->products; // Accessing the products from the subcategory
        return view('pages.subcategory_product', compact('subcategory', 'products'));
    }
    

    // public function products()
}
