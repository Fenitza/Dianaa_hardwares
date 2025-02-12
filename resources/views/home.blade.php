{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')
<!-- Hero Section -->

    <div class="hero-section" style="background-image: url('{{ asset('images/banners/hand_tools2.jpg') }}');">
    <div class="container h-100 d-flex align-items-center" style="padding-top: 0; margin-top: -50px;">
        <div class="text-white">
            <p class="lead mb-1">30% Discount</p>
            <h1 class="display-4">Best Hand Tools<br>Collection</h1>
            <a href="#" class="btn btn-danger btn-lg text-white mt-4">Shop Now</a>
        </div>
    </div>
</div>


<!-- Company Details Section -->
<div class="container my-4">
    <div class="row">
        <div class="col-md-6">
            <h2>We are Construction - <span class="intro">Leading provider of industrial and mechanical solutions.</span></h2>
            <p>Founded in 1970, our company has grown by leaps and bounds and had been setting new standards.<br> Starting out with only ability, enthusiasm and a clear vision of destination, our team has earned every single reputation and award.</p>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-around align-items-center h-100">
                <div class="service-item text-center p-3 bg-white border rounded shadow-sm">
                    <i class="fas fa-hammer fa-3x mb-3"></i>
                    <p>Construction</p>
                </div>
                <div class="service-item text-center p-3 bg-white border rounded shadow-sm">
                    <i class="fas fa-paint-roller fa-3x mb-3"></i>
                    <p>Renovations</p>
                </div>
                <div class="service-item text-center p-3 bg-white border rounded shadow-sm">
                    <i class="fas fa-seedling fa-3x mb-3"></i>
                    <p>Green Building</p>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Product Carousel Section -->
<div class="product-carousel">
    <a href="#" class="product-box">
        <img src="{{ asset('images/banners/Honeywell_banner.png') }}" alt="Honeywell Ultimate Protection and Comfort">
    </a>
    <a href="#" class="product-box">
        <img src="{{ asset('images/banners/Slice_banner.png') }}" alt="Slice Durable, Safe, Easy Access">
    </a>
    <a href="#" class="product-box">
        <img src="{{ asset('images/banners/Streamlight_banner.png') }}" alt="Streamlight Compact, Durable, Convenient">
    </a>
    <a href="#" class="product-box">
        <img src="{{ asset('images/banners/ergodyne_banner.png') }}" alt="Justrite Ultimate Flammable Liquid Safety">
    </a>
</div>

<!-- Brand Category -->
<div class="container my-4">
    <h3 class="text-center mb-3" style="color: #2d2e6a">FEATURED BRANDS</h3>
    <div class="row">
    @foreach($manufacturers as $manufacturer)
        <div class="col-md-4 col-sm-6 text-center mb-4">
            <a href="{{ route('products_main', ['manufacturer' => $manufacturer->ManufacturerID]) }}">
                <div class="brand-image-container">
                    <img src="{{ asset('images/logo/logo_brand.png') }}" alt="{{ $manufacturer->Manufacturer }}" class="brand-img" style="height: 200px;">
                    <p class="card-text-category">{{ $manufacturer->Manufacturer }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>



<!-- Spacer Block -->
<div class="custom-spacer"></div>


<!-- Product Categories -->
<div class="container my-4">
    <h3 class="text-center mb-3" style="color: #2d2e6a">PRODUCT CATEGORIES</h3>
    <div class="row">
    @foreach ($categories as $category)
        <div class="col-sm-4 col-md-4 col-lg-3 mb-4">
            <div class="card-category">
                <!-- <img src="{{ asset('storage/' . $category->image) }}" class="card-img-top" alt="{{ $category->name }}"> -->
                <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                <div class="card-body text-center">
                    <p class="card-text-category">{{ $category->Name }}</p>
                </div>
            </div>
        </div>
    @endforeach

        <!-- Explore All Products Button -->
        <div class="col-12 text-center mt-4">
            <a href="{{ route('products_main') }}" class="btn btn-primary" style="background-color: #a5cd36; color: #2d2e6a">Explore All Products</a>
        </div>
    </div>
</div>


@endsection
