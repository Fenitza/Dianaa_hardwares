@extends('layouts.app')

@section('content')

<!-- Product Tabs -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="product-nav-item">
                    <a class="product-nav-link active" aria-current="page" href="#">Bolts</a>
                </li>
                <li class="product-nav-item">
                    <a class="product-nav-link" href="#">Screws</a>
                </li>
                <li class="product-nav-item">
                    <a class="product-nav-link" href="#">Sockets</a>
                </li>
                <li class="product-nav-item">
                    <a class="product-nav-link" href="#">Nuts</a>
                </li>
                <li class="product-nav-item">
                    <a class="product-nav-link" href="#">Washers</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

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
    </div>
</div>
    

@endsection
