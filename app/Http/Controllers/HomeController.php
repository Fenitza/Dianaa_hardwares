<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Manufacturer;

class HomeController extends Controller
{
    public function index() {
        // Fetch all products with manufacturer details included
        $products = Product::with('manufacturer')->get();

        // Fetch all categories with subcategories that have products filtered by an optional manufacturer
        $categories = Category::with(['subcategories.products' => function ($query) {
            if (request()->has('manufacturer')) {
                $query->where('ManufacturerID', request('manufacturer'));
            }
        }])->get();

        // Fetch all manufacturers to possibly list or use in filtering
        $manufacturers = Manufacturer::all();

        return view('home', compact('products', 'categories', 'manufacturers'));
    }
}
