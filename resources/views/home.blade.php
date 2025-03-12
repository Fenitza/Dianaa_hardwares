{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div id="heroCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#heroCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#heroCarousel" data-slide-to="1"></li>
        <li data-target="#heroCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <div class="carousel-item active" style="background-image: url('images/banners/slider1.webp'); height: 400px;">
            <div class="carousel-caption d-none d-md-block">
                <!-- Optional: Add titles or descriptions here -->
            </div>
        </div>
        <div class="carousel-item" style="background-image: url('images/banners/slider2.webp'); height: 400px;">
            <div class="carousel-caption d-none d-md-block">
                <!-- Optional: Add titles or descriptions here -->
            </div>
        </div>
        <div class="carousel-item" style="background-image: url('images/banners/slider3.webp'); height: 400px;">
            <div class="carousel-caption d-none d-md-block">
                <!-- Optional: Add titles or descriptions here -->
            </div>
        </div>
    </div>

    <!-- Controls -->
    <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>




<!-- Company Details Section -->
<div class="container my-4">
    <div class="row">
        <div class="col-md-6">
            <h2>Dianaa Fasteners </h2>
            <p>Dianaa Fasteners is established as a key player in the fastener industry, aiming to provide quality products and services.
            <br> Starting out with only ability, enthusiasm and a clear vision of destination, our team has earned every single reputation and award.</p>
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



<!-- Manufacturer Category -->
<div class="container my-4">
    <h3 class="text-center mb-3" style="color: #2d2e6a">FEATURED BRANDS</h3>
    <div class="row">
    
    @foreach($manufacturers as $manufacturer)
    <div class="col-md-6 col-sm-6 text-center mb-4">
        <a href="{{ route('products_main', ['manufacturer' => $manufacturer->ManufacturerID]) }}">
            <div class="brand-image-container">
                <!-- Use the image field directly from the manufacturer record -->
                <img src="{{ asset('storage/' . $manufacturer->Image) }}" alt="{{ $manufacturer->Name }}" class="brand-img" style="height: 200px;">
            </div>
        </a>
    </div>
@endforeach
    </div>
</div>



<!-- Spacer Block -->
<div class="custom-spacer"></div>


<!-- Product Categories -->
<div class="card-container my-3">
    <h3 class="text-center mb-3" style="color: #2d2e6a">PRODUCT CATEGORIES</h3>
    <div class="row justify-content-center"> <!-- Ensure center alignment -->
        @foreach ($categories as $category)
        <div class="col-9 col-sm-5 col-md-4 col-lg-3 mb-4"> <!-- Adjusted for larger cards -->
            <div class="card-category text-center">
                <img src="{{ asset('storage/' . $category->category_image) }}" alt="{{ $category->Name }}" class="product-img img-fluid"
                style="width: auto; height: 150px; margin: 0 auto 20px; object-fit: contain;"> <!-- Increased height -->
                <div class="card-body">
                    <p class="card-text-category">{{ $category->Name }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-12 text-center mt-4">
            <a href="{{ route('products_main') }}" class="btn btn-primary" style="background-color: #a5cd36; color: #2d2e6a">Explore All Products</a>
        </div>
    </div>
</div>


@endsection

<script>
$(document).ready(function() {
    var myCarousel = document.querySelector('#heroCarousel')
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 5000,
        wrap: true
    });
});
</script>
