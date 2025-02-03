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


    <!-- Category and Product Section -->
    <div class="tabs-container">
    <div class="row mt-3">
        <div class="col-md-3">
            <!-- Category List -->
            <ul class="list-group">
                <li class="list-group-item active">Bolts</li>
                <li class="list-group-item">Screws</li>
                <li class="list-group-item">Sockets</li>
                <li class="list-group-item ">Nuts</li>
                <li class="list-group-item">Washers</li>
            </ul>
        </div>
        <div class="col-md-9">
            <!-- Products Tab -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#features">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#new-arrival">New Arrival</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#best-sellers">Best Sellers</a>
                </li>
            </ul>
            <div class="tab-content">
                <!-- Features Products -->
                <div class="tab-pane fade show active" id="features" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <!-- Product Card -->
                            <div class="card">
                                <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                                <div class="card-body">
                                    <h5 class="card-title">Product Name</h5>
                                    <p class="card-text">£100.00</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <!-- Product Card -->
                            <div class="card">
                                <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                                <div class="card-body">
                                    <h5 class="card-title">Product Name</h5>
                                    <p class="card-text">£100.00</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <!-- Product Card -->
                            <div class="card">
                                <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                                <div class="card-body">
                                    <h5 class="card-title">Product Name</h5>
                                    <p class="card-text">£100.00</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <!-- Product Card -->
                            <div class="card">
                                <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                                <div class="card-body">
                                    <h5 class="card-title">Product Name</h5>
                                    <p class="card-text">£100.00</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <!-- Product Card -->
                            <div class="card">
                                <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                                <div class="card-body">
                                    <h5 class="card-title">Product Name</h5>
                                    <p class="card-text">£100.00</p>
                                </div>
                            </div>
                        </div>
                        <!-- More products -->
                    </div>
                </div>


                <!-- Additional tabs content -->
                 <!-- New Arrival Products -->
                <div class="tab-pane fade" id="new-arrival" role="tabpanel">
                    <div class="row">
                        <!-- Product Card -->
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                                <div class="card-body">
                                    <h5 class="card-title">Product Name</h5>
                                    <p class="card-text">£200.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                                <div class="card-body">
                                    <h5 class="card-title">Product Name</h5>
                                    <p class="card-text">£300.00</p>
                                </div>
                            </div>
                        </div>
                        <!-- More products -->
                    </div>
                </div>

                <!-- Best Sellers Products -->
                <div class="tab-pane fade" id="best-sellers" role="tabpanel">
                    <div class="row">
                        <!-- Product Card -->
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                                <div class="card-body">
                                    <h5 class="card-title">Product Name</h5>
                                    <p class="card-text">£400.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                                <div class="card-body">
                                    <h5 class="card-title">Product Name</h5>
                                    <p class="card-text">£200.00</p>
                                </div>
                            </div>
                        </div>
                        <!-- More products -->
                    </div>
                </div>
                 
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
   






@endsection
