{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<!-- <div class="hero-section" style="background-image: url('{{ asset('images/banners/hand_tools2.jpg') }}'); background-size: cover; background-position: center; color: white;">
        <div class="hero-content">
            <p>30% Discount</p>
            <h1>Best Hand Tools <br> Collection</h1>
            <a href="#" class="shop-now-btn">Shop Now</a>
        </div>
    </div> -->

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

<!-- Company Details Section -->
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h2>We are Construction - <span class="text-primary">Leading provider of industrial and mechanical solutions.</span></h2>
            <p>Founded in 1970, our company has grown by leaps and bounds and had been setting new standards.<br>
            Starting put with only ability, enthusiasm and a clear vision of destination, our team has earned every single reputation and award.</p>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4 text-center">
                    <i class="fas fa-hammer fa-3x"></i>
                    <p>Construction</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fas fa-paint-roller fa-3x"></i>
                    <p>Renovations</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fas fa-seedling fa-3x"></i>
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

<!-- Product Tab Section -->
<div class="products-section">
<div class="quick-links">
        
        <ul>
            <li><a href="#">Quick Links</a></li>
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

    <!-- Product Categories  -->
    <div class="product-categories">
        <h2>PRODUCT CATEGORIES</h2>
        <div class="categories-grid">
            <div class="category-item">
                <img src="{{ asset('images/Products/product_1.jpg') }}" alt="Fasteners">
                <p>Fasteners</p>
            </div>
            <div class="category-item">
                <img src="{{ asset('images/Products/product_1.jpg') }}" alt="Safety">
                <p>Safety</p>
            </div>
            <div class="category-item">
                <img src="{{ asset('images/Products/product_1.jpg') }}" alt="Janitorial and Cleaning">
                <p>Janitorial and Cleaning</p>
            </div>
            <div class="category-item">
                <img src="{{ asset('images/Products/product_1.jpg') }}" alt="Fasteners">
                <p>Fasteners</p>
            </div>
            <div class="category-item">
                <img src="{{ asset('images/Products/product_1.jpg') }}" alt="Safety">
                <p>Safety</p>
            </div>
            <div class="category-item">
                <img src="{{ asset('images/Products/product_1.jpg') }}" alt="Janitorial and Cleaning">
                <p>Janitorial and Cleaning</p>
            </div>
            <div class="category-item">
                <img src="{{ asset('images/Products/product_1.jpg') }}" alt="Fasteners">
                <p>Fasteners</p>
            </div>
            <div class="category-item">
                <img src="{{ asset('images/Products/product_1.jpg') }}" alt="Safety">
                <p>Safety</p>
            </div>
            <div class="category-item">
                <img src="{{ asset('images/Products/product_1.jpg') }}" alt="Janitorial and Cleaning">
                <p>Janitorial and Cleaning</p>
            </div>
            
            <!-- Repeat for other categories -->
        </div>
        <button>Explore All Products</button>
    </div>
    <div class="container text-center">
    <h2>PRODUCT CATEGORIES</h2>
    <div class="row">
        <div class="col-6 col-md-3 col-lg-2">
            <img src="path_to_fasteners_image.jpg" alt="Fasteners" class="img-fluid">
            <p>Fasteners</p>
        </div>
        <!-- Repeat for each category, adjusting col classes -->
    </div>
    <button class="btn btn-primary mt-4">Explore All Products</button>
</div>

    <!-- Services Section -->
    <div class="product-service-offers">
    <div class="product-service-item">
        <i class="fas fa-grin-beam fa-2x"></i>
        <span>100% Satisfaction<br>If you are unable</span>
    </div>
    <div class="product-service-item">
        <i class="fas fa-tags fa-2x"></i>
        <span>Save 20% When You<br>Use credit card</span>
    </div>
    <div class="product-service-item">
        <i class="fas fa-shipping-fast fa-2x"></i>
        <span>Fast Free Shipment<br>Load any computer's</span>
    </div>
    <div class="product-service-item">
        <i class="fas fa-undo fa-2x"></i>
        <span>14-Day Money Back<br>If you are unable</span>
    </div>
    </div>
    <!-- Footer -->
    <footer class="site-footer">
    <div class="footer-container">
        <div class="footer-column">
            <h4>Products</h4>
            <ul>
                <li><a href="#">Prices drop</a></li>
                <li><a href="#">New products</a></li>
                <li><a href="#">Best sales</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Our company</h4>
            <ul>
                <li><a href="#">Delivery</a></li>
                <li><a href="#">Legal Notice</a></li>
                <li><a href="#">Terms and conditions of use</a></li>
                <li><a href="#">About us</a></li>
                <li><a href="#">Secure payment</a></li>
                <li><a href="#">Contact us</a></li>
                <li><a href="#">Sitemap</a></li>
                <li><a href="#">Stores</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Your account</h4>
            <ul>
                <li><a href="#">Personal info</a></li>
                <li><a href="#">Orders</a></li>
                <li><a href="#">Credit slips</a></li>
                <li><a href="#">Addresses</a></li>
                <li><a href="#">Wishlist</a></li>
                <li><a href="#">Compare</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Store Information</h4>
            <p>ToolShop, Russia</p>
            <p>Tel: 123 456 789</p>
            <p>Email: demo@demo.com</p>
            <div class="payment-methods">
                <i class="fab fa-cc-visa" aria-hidden="true"></i>
                <i class="fab fa-cc-paypal" aria-hidden="true"></i>
                <i class="fab fa-cc-mastercard" aria-hidden="true"></i>
                <i class="fab fa-cc-amex" aria-hidden="true"></i>
                <i class="fab fa-cc-discover" aria-hidden="true"></i>
            </div>
        </div>
    </div>
</footer>






@endsection
