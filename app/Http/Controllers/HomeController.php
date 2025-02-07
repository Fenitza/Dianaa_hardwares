<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $products = Product::all();  // Fetch all products or apply some filtering
        $categories = Category::with('subcategories')->get();

    
        return view('home', compact('products', 'categories'));
    }
}
