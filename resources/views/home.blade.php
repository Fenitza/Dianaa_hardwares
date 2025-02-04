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


    <!-- Category and Product Section tabs -->
    <!-- <div class="tabs-container">
    <div class="row mt-3">
        <div class="col-md-3">
            Category List
            <ul class="list-group">
            <li class="list-group-item active" data-target="#features">Bolts</li>
                <li class="list-group-item" data-target="#new-arrival">Screws</li>
                <li class="list-group-item" data-target="#best-sellers">Sockets</li>
                <li class="list-group-item" data-target="#features">Nuts</li>
                <li class="list-group-item" data-target="#new-arrival">Washers</li>
            </ul>
        </div> -->

        <div class="tabs-container">
    <div class="row mt-3">
        <div class="col-md-3">
            <!-- Dynamic Category List -->
            <ul class="list-group">
                @foreach ($categories as $category)
                    <li class="list-group-item" data-target="#{{ strtolower(str_replace(' ', '-', $category->name)) }}">
                        {{ $category->name }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
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

<!-- Spacer Block -->
<div class="custom-spacer"></div>


<!-- Product Categories -->
<div class="container my-4">
    <h3 class="text-center mb-3" style="color: #2d2e6a">PRODUCT CATEGORIES</h3>
    <div class="row">
    <!-- Individual Categories -->
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card-category">
            <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                <div class="card-body text-center">
                    <p class="card-text-category">Fasteners</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card-category">
            <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                <div class="card-body text-center">
                    <p class="card-text-category">Safety</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card-category">
            <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                <div class="card-body text-center">
                    <p class="card-text-category">Fasteners</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card-category">
            <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                <div class="card-body text-center">
                    <p class="card-text-category">Safety</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card-category">
            <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                <div class="card-body text-center">
                    <p class="card-text-category">Fasteners</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card-category">
            <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                <div class="card-body text-center">
                    <p class="card-text-category">Safety</p>
                </div>
            </div>
        </div><div class="col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card-category">
            <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                <div class="card-body text-center">
                    <p class="card-text-category">Fasteners</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card-category">
            <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
                <div class="card-body text-center">
                    <p class="card-text-category">Safety</p>
                </div>
            </div>
        </div>
        <!-- Repeat blocks for each category -->

        <!-- Explore All Products Button -->
        <div class="col-12 text-center mt-4">
            <a href="#" class="btn btn-primary" style="background-color: #a5cd36; color: #2d2e6a">Explore All Products</a>
        </div>
    </div>
</div>


   
   






@endsection
