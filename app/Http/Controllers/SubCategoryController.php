<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function show(Request $request, $subCategoryId) {
        // Validate sort and view inputs
        $sortOrder = $request->query('sort', 'best_match');
        $validSortOptions = ['best_match', 'price_low_high', 'price_high_low'];
        if (!in_array($sortOrder, $validSortOptions)) {
            $sortOrder = 'best_match'; // Default if invalid sort order provided
        }
    
        $viewType = $request->query('view', 'grid');
        $validViewTypes = ['grid', 'list', 'catalog'];
        if (!in_array($viewType, $validViewTypes)) {
            $viewType = 'grid'; // Default if invalid view type provided
        }

        // Prepare to query the subcategory with its products
        $subcategory = SubCategory::with(['products' => function($query) use ($request, $sortOrder) {
            // Apply filters based on request inputs
            if ($request->filled('manufacturer')) {
                $query->whereIn('manufacturer', $request->manufacturer);
            }

            if ($request->filled('material')) {
                $query->whereIn('material', $request->material);
            }

            // Apply sorting
            switch ($sortOrder) {
                case 'price_low_high':
                    $query->orderBy('SalePrice', 'asc');
                    break;
                case 'price_high_low':
                    $query->orderBy('SalePrice', 'desc');
                    break;
                default:
                    $query->orderBy('Name', 'asc'); // Treats 'best_match' as a default case
                    break;
            }
        }])->findOrFail($subCategoryId);
    
        $products = $subcategory->products;
        return view('pages.subcategory_product', compact('subcategory', 'products', 'viewType'));
    }

    public function filter(Request $request, $subCategoryId) {
        $query = SubCategory::with(['products' => function($q) use ($request) {
            if ($request->filled('availability')) {
                // Add availability filter logic
            }
            if ($request->filled('manufacturer')) {
                $q->whereIn('manufacturer', $request->manufacturer);
            }
            if ($request->filled('material')) {
                $q->whereIn('material', $request->material);
            }
        }])->findOrFail($subCategoryId);
    
        $products = $query->products;
    
        return response()->json([
            'html' => view('partials.product_grid', compact('products'))->render()
        ]);
    }
}
