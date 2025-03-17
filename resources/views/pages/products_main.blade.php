@extends('layouts.app')

@section('content')
<div class="custom-spacer"></div>

<!-- Product Categories -->
<div class="card-container my-4">
    <h3 class="text-center mb-3" style="color: #2d2e6a">PRODUCT CATEGORIES</h3>
    <div class="row justify-content-center"> <!-- Ensure center alignment -->
        @foreach ($categories as $category)
        <div class="col-9 col-sm-5 col-md-4 col-lg-3 mb-4"> <!-- Adjusted for larger cards -->
            <!-- The <a> tag starts here, wrapping the whole card -->
            <a href="{{ route('products', ['category' => $category->CategoryID, 'manufacturer' => request()->manufacturer]) }}">
                <div class="card-category text-center">
                    <img src="{{ asset('storage/' . $category->category_image) }}" alt="{{ $category->Name }}" class="product-img img-fluid"
                         style="width: auto; height: 150px; margin: 0 auto 20px; object-fit: contain;"> <!-- Increased height -->
                    <div class="card-body">
                        <p class="card-text-category">{{ $category->Name }}</p>
                    </div>
                </div>
            </a> <!-- The <a> tag ends here -->
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
