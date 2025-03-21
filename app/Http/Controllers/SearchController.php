<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Manufacturer;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $products = Product::with(['subcategory', 'manufacturer'])
            ->where('name', 'LIKE', "%{$query}%")
            ->get();

        $subcategories = SubCategory::where('name', 'LIKE', "%{$query}%")->get();

        $manufacturers = Manufacturer::where('name', 'LIKE', "%{$query}%")->get();

        return view('search.results', compact('products', 'subcategories', 'manufacturers'));
    }
}
