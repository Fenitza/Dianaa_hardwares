{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')

<!-- Hero Image Carousel -->
<div class="col-md-12">
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <!-- Indicators/dots -->
    <ol class="carousel-indicators">
        <li data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#heroCarousel" data-bs-slide-to="1"></li>
        
    </ol>

    <!-- The slideshow/images -->
    <div class="carousel-inner" role="listbox">
    `<div class="carousel-item active" style="background: url('/images/banners/slider1.webp') center center / cover no-repeat; height: 400px;"></div>
    <div class="carousel-item" style="background: url('/images/banners/slider2.webp') center center / cover no-repeat; height: 400px;"></div>
</div>`
    <!-- Left and right controls/icons -->
    <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </a>
    <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </a>
</div>
</div>


<div class="container my-4">
    <!-- Company Details Section -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="company-details">
                
                <p>Dianaa Fasteners is established as a key player in the fastener industry, 
                <br> aiming to provide quality products and services.
                <br> Starting out with only ability, enthusiasm, and a clear vision of destination,
                <br> our team has earned every single reputation and award.</p>
            </div>
        </div>
    </div>
</div>



<!-- Featured Brands -->
<div id="featured-brands">
    <h2 class="section-title">Featured Brands</h2>
    <div class="row justify-content-center">
        @foreach($manufacturers as $manufacturer)
        <div class="col-md-3 col-sm-6 text-center mb-4">
            <div class="brand-card" style="background-image: url('{{ asset('storage/' . $manufacturer->Image) }}');">
                <div class="brand-overlay">
                    <h4 class="brand-name">{{ $manufacturer->Name }}</h4>
                    <a href="{{ route('products_main', ['brand' => $manufacturer->Name]) }}" class="shop-now-btn">SHOP NOW</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>



<!-- Product Categories -->
<div id="product-categories">
    <h2 class="section-title">Product Categories</h2>
    <div class="row justify-content-center">
        @foreach ($categories as $category)
        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
            <div class="categ-card text-center">
                <img src="{{ asset('storage/' . $category->category_image) }}" alt="{{ $category->Name }}" class="product-img img-fluid" style="height: 100px;">
                <div class="card-body">
                    <p class="categ-card-title">{{ $category->Name }}</p>
                </div>
                <div class="category-overlay">
                    <ul class="subcategory-links">
                        @foreach ($category->subcategories->take(3) as $subcategory)
                        <li><a href="{{ route('subcategory_product', ['subCategoryId' => $subcategory->SubCategoryID]) }}">{{ $subcategory->Name }}</a></li>
                        @endforeach
                        <li><a href="{{ route('products', ['category' => $category->CategoryID]) }}" class="view-all-link">View All</a></li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Product table container -->
<div class="product-table-container mt-4">
    <div class="row">
        <!-- First column for categories and subcategories -->
        <div class="col-md-3 category-sidebar">
            @foreach ($categories as $category)
                <div class="category-item">
                    <button class="category-toggle" onclick="toggleSubcategories('subcat-{{ $category->CategoryID }}')">
                        {{ $category->Name }}
                    </button>
                    <ul class="subcategory-list" id="subcat-{{ $category->CategoryID }}" style="display: none;">
                        @foreach ($category->subcategories as $subcategory)
                            <li class="subcategory-item">
                                <a href="javascript:void(0);" onclick="loadProducts({{ $subcategory->SubCategoryID }})">
                                    {{ $subcategory->Name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
        
        <!-- Second column for displaying products -->
        <div class="col-md-9" id="products-display" class="categ-card">
            <!-- Default message when no subcategory is selected -->
            <div id="default-message" class="text-center mt-5">
                <p>Select Categories from here</p>
                <i class="fas fa-hand-point-left"></i> <!-- FontAwesome icon example -->
            </div>
            <!-- Products will be dynamically loaded here via JavaScript -->
        </div>
    </div>
</div>



<!-- Testimonials Section -->
<div class="testimonials-container my-4">
    <h2 class="section-title ">What Our Clients say</h2>
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
    <h2 class="section-title ">Latest News</h2>
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



@endsection


<script>
document.addEventListener('DOMContentLoaded', function() {
    var myCarousel = document.querySelector('#heroCarousel');
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 5000,  // Carousel changes every 3 seconds
        wrap: true       // Allows the carousel to loop continuously
    });

    // Optional: To add interactions if needed
    document.querySelectorAll('.carousel-control-prev, .carousel-control-next').forEach(function(control) {
        control.addEventListener('click', function(e) {
            e.preventDefault();
            if (this.classList.contains('carousel-control-next')) {
                carousel.next();
            } else {
                carousel.prev();
            }
        });
    });

    document.querySelectorAll('.carousel-indicators li').forEach(function(indicator, idx) {
        indicator.addEventListener('click', function(e) {
            e.preventDefault();
            carousel.to(idx); // Move to the slide indexed by the clicked indicator
        });
    });
});



function toggleSubcategories(subcatId) {
    var element = document.getElementById(subcatId);
    element.style.display = (element.style.display === 'none') ? 'block' : 'none';
}

// Function to load products for a specific subcategory
function loadProducts(subcategoryId) {
    fetch(`/subcategories/${subcategoryId}/products`)
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('products-display');
        container.innerHTML = ''; // Clear existing content
        if (data.length > 0) {
            data.forEach(product => {
                container.innerHTML += `
                <a href="/subcategories/product/${product.ProductID}" class="card-link">
                    <div class="card mb-3">
                        <img src="/storage/${product.product_image}" class="card-img-top" alt="${product.name}">
                        <div class="card-body">
                            <h6 class="card-title">${product.Name}</h6>
                            <p class="card-text"><small class="text-muted">₹${product.SalePrice}</small></p>
                        </div>
                    </div>
                </a>
                `;
            });
            // Append View All button here, inside the check where products are found
            container.innerHTML += `
                <div class="text-center view-all-container">
                    <a href="/subcategories/${subcategoryId}" class="btn btn-primary">View All</a>
                </div>
            `;
        } else {
            container.innerHTML = '<p>No products found in this category.</p>';
        }
    })
    .catch(error => {
        console.error('Error loading products:', error);
        container.innerHTML = '<p>Error loading products. Please try again later.</p>';
    });
    
}

document.addEventListener('DOMContentLoaded', function() {
    console.log("DOMContentLoaded event triggered");

      @if(count($categories) > 0 && count($categories[0]->subcategories) > 0)
        // Automatically load products for the first subcategory of the first category
        loadProducts({{ $categories[0]->subcategories[0]->SubCategoryID }});
    @endif

});



</script>

