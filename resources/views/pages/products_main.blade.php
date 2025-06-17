@extends('layouts.app')
<title>Product Categories-Dianaa Fasteners</title>
@section('content')

 <!-- Spacer Block -->
<div class="custom-spacer" style="height: 20px;"></div>

<!-- Product Categories -->
<div id="product-categories">
    <h2 class="section-title">Product Categories</h2>
    <div class="row justify-content-center">
        @foreach ($categories as $category)
        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
            <div class="categ-card text-center">
                <img src="{{ asset('storage/' . $category->category_image) }}" alt="{{ $category->Name }}" class="product-img img-fluid" style="height: 100px;">
                <div class="card-body">
                    <p class="categ-card-title">{{ $category->Name }}</p>
                </div> 
                <div class="category-overlay">
                    <ul class="subcategory-links">
                        @foreach ($category->subcategories->take(3) as $subcategory)
                        <li>@php
    $brands = request()->input('brand', []);
    $query = ['brand' => (array) $brands];
    $queryString = http_build_query($query);
@endphp

<a href="{{ route('subcategory_product', ['subCategoryId' => $subcategory->SubCategoryID]) }}{{ $queryString ? '?' . $queryString : '' }}" class="card-link-category">
    {{ $subcategory->Name }}
</a>

                        </li>
                        @endforeach
                        <li><a href="{{ route('products', ['category' => $category->CategoryID, 'brand' => request()->brand]) }}" class="view-all-link">View All</a></li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


    <!-- Explore All Products Button -->
    <!-- <div class="col-12 text-center mt-4">
        <a href="{{ route('products', ['manufacturer' => request()->manufacturer]) }}" class="btn btn-primary" style="background-color: #a5cd36; color: #2d2e6a">Explore All Products</a>
    </div>
</div> -->
@endsection
