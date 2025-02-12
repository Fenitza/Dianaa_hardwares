@extends('layouts.app')

@section('content')
<div class="custom-spacer"></div>

<!-- Product Categories -->
<div class="container my-4">
    <h3 class="text-center mb-3" style="color: #2d2e6a">PRODUCT CATEGORIES</h3>
    <div class="row">
    @foreach ($categories as $category)
        <div class="col-sm-4 col-md-4 col-lg-3 mb-4">
        <a href="{{ route('products', ['category' => $category->CategoryID, 'manufacturer' => request()->manufacturer]) }}" class="card-category">
            <div class="card-category">
                <!-- <img src="{{ asset('storage/' . $category->image) }}" class="card-img-top" alt="{{ $category->name }}"> -->
                <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                <div class="card-body text-center">
                    <p class="card-text-category">{{ $category->Name }}</p>
                </div>
               
            </div>
            </a>
        </div>
    @endforeach
</div>


        <!-- Explore All Products Button -->
        <div class="col-12 text-center mt-4">
        <a href="{{ route('products', ['manufacturer' => request()->manufacturer]) }}" class="btn btn-primary" style="background-color: #a5cd36; color: #2d2e6a">Explore All Products</a>
        </div>
    </div>
</div>
@endsection
