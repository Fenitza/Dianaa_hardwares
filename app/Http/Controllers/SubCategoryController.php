<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function show(Request $request, $subCategoryId) {
        $subcategory = SubCategory::with(['products' => function($query) use ($request) {
            $sortOrder = $request->query('sort', 'best_match'); // Default sort order

            switch ($sortOrder) {
                case 'price_low_high':
                    $query->orderBy('SalePrice', 'asc');
                    break;
                case 'price_high_low':
                    $query->orderBy('SalePrice', 'desc');
                    break;
                default:
                    // Default case can either be an actual column or just the default arrangement
                    $query->orderBy('Name', 'asc'); // Example: Sort by product name alphabetically
                    break;
            }
        }])->findOrFail($subCategoryId);

        $products = $subcategory->products; // Products are already sorted by the query
        return view('pages.subcategory_product', compact('subcategory', 'products'));
    }
    

    // public function products()
}
