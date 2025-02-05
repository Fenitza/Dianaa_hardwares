<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        // $categories = Category::all(); // Fetch all categories
        // Log::info('Categories retrieved: ', $categories->toArray()); // Log the data
        // return view('home', ['categories' => $categories]); // Pass them to the home view

        $categories = Category::with('subcategories')->get();

        // Pass the categories to the view
        return view('home', ['categories' => $categories]);
    }
}
