{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="hero-section" style="background-image: url('{{ asset('images/banners/hand_tools2.jpg') }}'); background-size: cover; background-position: center; color: white;">
        <div class="hero-content">
            <p>30% Discount</p>
            <h1>Best Hand Tools <br> Collection</h1>
            <a href="#" class="shop-now-btn">Shop Now</a>
        </div>
    </div>
<!-- Company Details Section -->
    <div class="company-details">
    <div class="company-text">
        <h2>We are Construction - <span class="intro">Leading provider of industrial and mechanical solutions.</span></h2>
        <p>Founded in 1970, our company has grown by leaps and bounds and had been setting new standards.<br> Starting put with only ability, enthusiasm and a clear vision of destination, our team has earned every single reputation and award.</p>
    </div>
    <div class="services">
        <div class="service-item">
            <i class="fas fa-hammer fa-3x"></i>
            <p>Construction</p>
        </div>
        <div class="service-item">
            <i class="fas fa-paint-roller fa-3x"></i>
            <p>Renovations</p>
        </div>
        <div class="service-item">
            <i class="fas fa-seedling fa-3x"></i>
            <p>Green Building</p>
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

<!-- Product Tab Section -->
<div class="products-section">
<div class="quick-links">
        <h3>Quick Links</h3>
        <ul>
            <li><a href="#">Hex Head</a></li>
            <li><a href="#">Socket Head</a></li>
            <li><a href="#">Washers</a></li>
            <li><a href="#">Nuts</a></li>
            <li><a href="#">Standard Products</a></li>
            <li><a href="#">Coatings</a></li>
        </ul>
    </div>
    <div class="product-main-content">
        <div class="tabs">
            <button class="tab-button active" onclick="showCategory('features')">Features</button>
            <button class="tab-button" onclick="showCategory('new-arrival')">New Arrival</button>
            <button class="tab-button" onclick="showCategory('best-sellers')">Best Sellers</button>
        </div>
        <div class="product-container">
            <div class="product-category active" id="features">
                <!-- Product Cards for Features -->
                <div class="product-card">
                <img src="{{ asset('images/Products/product_1.jpg') }}" alt="Product 1">
                <h3>Product Name</h3>
                <p>£100.00</p>
            </div>
            <div class="product-card">
                <img src="{{ asset('images/Products/product_1.jpg') }}" alt="Product 1">
                <h3>Product Name</h3>
                <p>£100.00</p>
            </div>
            <div class="product-card">
                <img src="{{ asset('images/Products/product_1.jpg') }}" alt="Product 1">
                <h3>Product Name</h3>
                <p>£100.00</p>
            </div>
            <div class="product-card">
                <img src="{{ asset('images/Products/product_1.jpg') }}" alt="Product 1">
                <h3>Product Name</h3>
                <p>£100.00</p>
            </div>
            </div>
            <div class="product-category" id="new-arrival">
                <!-- Product Cards for New Arrival -->
                <div class="product-card">
                <img src="{{ asset('images/Products/product_1.jpg') }}" alt="Product 1">
                <h3>Product Name</h3>
                <p>£100.00</p>
            </div>
            <div class="product-card">
                <img src="{{ asset('images/Products/product_1.jpg') }}" alt="Product 1">
                <h3>Product Name</h3>
                <p>£100.00</p>
            </div>
            </div>
            <div class="product-category" id="best-sellers">
                <!-- Product Cards for Best Sellers -->
                <div class="product-card">
                <img src="{{ asset('images/Products/product_1.jpg') }}" alt="Product 1">
                <h3>Product Name</h3>
                <p>£100.00</p>
            </div>
            <div class="product-card">
                <img src="{{ asset('images/Products/product_1.jpg') }}" alt="Product 1">
                <h3>Product Name</h3>
                <p>£100.00</p>
            </div>
            </div>
        </div>
    </div>
</div>

@endsection
