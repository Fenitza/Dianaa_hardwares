{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')

<!-- Hero Carousel -->
<div id="heroCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">
    <ol class="carousel-indicators">
        <li data-target="#heroCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#heroCarousel" data-slide-to="1"></li>
        <li data-target="#heroCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="carousel-item active" style="background-image: url('images/banners/slider1.webp'); height: 400px;"></div>
        <div class="carousel-item " style="background-image: url('images/banners/careers.jpg'); height: 400px;"></div>
    </div>
    <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="container my-4">
    <!-- Company Details Section -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="company-details">
                <h2 class="company-title">Dianaa Fasteners</h2>
                <p class="company-description">Dianaa Fasteners is established as a key player in the fastener industry, aiming to provide quality products and services.
                <br> Starting out with only ability, enthusiasm, and a clear vision of destination, our team has earned every single reputation and award.</p>
            </div>
        </div>
    </div>
</div>

<!-- Spacer Block -->
<div class="custom-spacer"></div>

<!-- Featured Brands -->
<div class="card-container my-4">
    <h3 class="text-center mb-3" style="color: #2d2e6a; text-transform: uppercase; font-weight: bold;">FEATURED BRANDS</h3>
    <div class="row justify-content-center">
        @foreach($manufacturers as $manufacturer)
        <div class="col-md-3 col-sm-6 text-center mb-4">
            <div class="brand-card" style="background-image: url('{{ asset('storage/' . $manufacturer->Image) }}');">
                <div class="brand-overlay">
                    <h4 class="brand-name">{{ $manufacturer->Name }}</h4>
                    <a href="{{ route('products_main', ['manufacturer' => $manufacturer->ManufacturerID]) }}" class="shop-now-btn">SHOP NOW</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Spacer Block -->
<div class="custom-spacer"></div>

<!-- Product Categories -->
<div class="card-container my-3">
    <h3 class="text-center mb-3" style="color: #2d2e6a">PRODUCT CATEGORIES</h3>
    <div class="row justify-content-center">
        @foreach ($categories as $category)
        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">  <!-- Adjusted column sizes -->
            <div class="card-category text-center" style="position: relative; overflow: hidden;">
                <img src="{{ asset('storage/' . $category->category_image) }}" alt="{{ $category->Name }}" class="product-img img-fluid"
                style="width: 100%; height: 150px; object-fit: contain;">  <!-- Adjusted image styling -->
                <div class="card-body">
                    <p class="card-text-category">{{ $category->Name }}</p>
                </div>
                <div class="category-overlay" style="display: none;"> <!-- Initial display none -->
                    <ul class="subcategory-links">
                        @foreach ($category->subcategories as $subcategory)
                        <li><a href="{{ route('products', ['category' => $category->CategoryID, 'subcategory' => $subcategory->SubcategoryID]) }}" style="color: white; text-decoration: none;">{{ $subcategory->Name }}</a></li>
                        @endforeach
                        <li><a href="{{ route('products', ['category' => $category->CategoryID]) }}" style="color: white; text-decoration: none;">View All</a></li>  <!-- View all subcategories link -->
                    </ul>
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


<!-- Testimonials Section -->
<div class="testimonials-container my-4">
    <h3 class="text-center">What Our Clients Say</h3>
    <div class="row">
        <div class="col-md-4">
            <blockquote class="blockquote">
                <p>"Excellent products and fantastic customer service."</p>
                <footer class="blockquote-footer">John Doe, <cite title="Source Title">Construction Co.</cite></footer>
            </blockquote>
        </div>
        <div class="col-md-4">
            <blockquote class="blockquote">
                <p>"The quality of fasteners is unmatched. Highly recommend!"</p>
                <footer class="blockquote-footer">Jane Smith, <cite title="Source Title">DIY Enthusiast</cite></footer>
            </blockquote>
        </div>
        <div class="col-md-4">
            <blockquote class="blockquote">
                <p>"They really help us to ensure our projects are completed on time with the highest quality."</p>
                <footer class="blockquote-footer">Michael Brown, <cite title="Source Title">Renovations Specialist</cite></footer>
            </blockquote>
        </div>
    </div>
</div>

<!-- Latest News Section -->
<div class="news-container my-4">
    <h3 class="text-center">Latest News</h3>
    <div class="row">
        <div class="col-md-6">
            <div class="news-item">
                <h4>New Product Launch</h4>
                <p>We are excited to announce the launch of our new line of eco-friendly fasteners!</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="news-item">
                <h4>Industry Award Received</h4>
                <p>Our commitment to quality was recognized at the Global Fasteners Summit last week.</p>
            </div>
        </div>
    </div>
</div>

<!-- Spacer Block -->
<div class="custom-spacer"></div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#heroCarousel').carousel({
        interval: 5000,
        wrap: true
    });
});
</script>
@endpush
