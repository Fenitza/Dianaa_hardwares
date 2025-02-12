<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $products = Product::all(); // Fetch all products or apply some filtering
        $categories = Category::with(['subcategories' => function ($query) {
            $query->whereHas('products', function ($subQuery) {
                $subQuery->where('ManufacturerID', request()->manufacturer); // Assuming a manufacturer filter is applied
            });
        }])->get();
    
        // Fetching unique manufacturers and their IDs from the products table
        $manufacturers = Product::select('Manufacturer', 'ManufacturerID')->distinct()->get();
    
        return view('home', compact('products', 'categories', 'manufacturers'));
    }
   
}