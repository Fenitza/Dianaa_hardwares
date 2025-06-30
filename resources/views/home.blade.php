{{-- resources/views/home.blade.php --}}
@extends('layouts.app')
<title>Dianaa Fasteners - Leading Provider of Engineering and Fasteners Solutions</title>

@section('content')

<!-- Hero Image Carousel -->
<div class="col-md-12">
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" style="background-color:#a79a9a;">
    

    <!-- The slideshow/images -->
    <div class="carousel-inner" role="listbox">
    <div class="carousel-item active">
        <img src="/images/banners/slider1.webp" alt="Slider Image 1" style="width:100%; height:auto; object-fit: fill;">
    </div>
    <div class="carousel-item">
        <img src="/images/banners/slider2.webp" alt="Slider Image 2" style="width:100%; height:auto; object-fit: fill;">
    </div>
</div>

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
<!-- Indicators/dots -->
    <ol class="carousel-indicators">
        <li data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#heroCarousel" data-bs-slide-to="1"></li>
        
    </ol>
</div>

<div class="company-details-align-center py-5 px-4 mx-auto" style="max-width: 1200px;">
    <div class="row align-items-center">
        <!-- Text Section -->
        <div class="col-lg-6 col-md-12 col-sm-12 mb-4">
            <div class="company-text text-center text-md-start">
                <h2 style="font-weight: bold; color: #000;">Dianaa Fasteners</h2>
                <h4 style="color: #4a4a4a; margin-bottom: 1rem;">Leading Provider of Engineering and Fasteners Solutions</h4>
                <p style="color: #555;">
                    Dianaa Fasteners is established as a key player in the fastener industry, aiming to provide quality products and services.
                    Starting out with only ability, enthusiasm, and a clear vision of destination, our team has earned every single reputation and award.
                </p>
            </div>
        </div>

        <!-- Services Section (Always visible, in row for all screens) -->
        <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="services d-flex justify-content-center flex-row flex-wrap gap-3">
    <div class="service-item text-center p-3 shadow-sm rounded d-flex flex-column align-items-center justify-content-center" style="min-width: 100px; height: 180px;">
        <i class="fas fa-hammer fa-3x" style="color: #ff7f50; margin-bottom: 0.5rem;"></i>
        <p style="color: #000; margin: 0;">Construction</p>
    </div>
    <div class="service-item text-center p-3 shadow-sm rounded d-flex flex-column align-items-center justify-content-center" style="min-width: 100px; height: 180px;">
        <i class="fas fa-paint-roller fa-3x" style="color: #32cd32; margin-bottom: 0.5rem;"></i>
        <p style="color: #000; margin: 0;">Renovations</p>
    </div>
    <div class="service-item text-center p-3 shadow-sm rounded d-flex flex-column align-items-center justify-content-center" style="min-width: 100px; height: 180px;">
        <i class="fas fa-seedling fa-3x" style="color: #1e90ff; margin-bottom: 0.5rem;"></i>
        <p style="color: #000; margin: 0;">Green Building</p>
    </div>
</div>

        </div>
    </div>
</div>




<!-- Featured Brands -->
<div id="featured-brands" class="py-5">
    <h2 class="section-title text-center mb-4">Featured Brands</h2>
    <div class="row justify-content-center">
        @foreach($manufacturers as $manufacturer)
        <div class="col-lg-3 col-md-4 col-sm-6 col-8 text-center mb-4">
            <div class="brand-card mx-auto" style="background-image: url('{{ asset('storage/' . $manufacturer->Image) }}'); max-width: 250px; min-height: 150px; background-size: contain; background-repeat: no-repeat; background-position: center;">
                <div class="brand-overlay d-flex flex-column justify-content-center align-items-center h-100">
                    <h4 class="brand-name mb-2">{{ $manufacturer->Name }}</h4>
                    <a href="{{ route('products.byBrandCategories', ['brand_id' => $manufacturer->ManufacturerID]) }}?brand={{ $manufacturer->ManufacturerID }}" class="shop-now-btn  btn-sm">SHOP NOW</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

 
<div class="container product-table-container mt-4">
  <div class="row">

    <!-- Accordion for Small Screens -->
    <div class="col-12 d-block d-md-none mb-3">
      <div class="accordion" id="categoryAccordion">
        @foreach ($categories as $category)
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading-{{ $category->CategoryID }}">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#collapse-{{ $category->CategoryID }}" aria-expanded="false"
                      aria-controls="collapse-{{ $category->CategoryID }}">
                {{ $category->Name }}
              </button>
            </h2>
            <div id="collapse-{{ $category->CategoryID }}" class="accordion-collapse collapse"
                 aria-labelledby="heading-{{ $category->CategoryID }}" data-bs-parent="#categoryAccordion">
              <div class="accordion-body p-2">
                <ul class="list-unstyled">
                  @foreach ($category->subcategories as $subcategory)
                    <li class="mb-1">
                      <a href="javascript:void(0);"
                         onclick="selectSubcategory(this, {{ $subcategory->SubCategoryID }})"
                         class="subcategory-link text-decoration-none">
                        {{ $subcategory->Name }}
                      </a>
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Sidebar for Large Screens -->
    <div class="col-md-3 d-none d-md-block category-sidebar">
      @foreach ($categories as $category)
        <div class="category-item mb-2">
          <button class="category-toggle text-start"
                  onclick="toggleSubcategories('subcat-{{ $category->CategoryID }}')">
            {{ $category->Name }}
          </button>
          <ul class="subcategory-list list-unstyled ps-3 pt-2" id="subcat-{{ $category->CategoryID }}" style="display: none;">
            @foreach ($category->subcategories as $subcategory)
              <li class="subcategory-item mb-1">
                <a href="javascript:void(0);"
                   onclick="selectSubcategory(this, {{ $subcategory->SubCategoryID }})"
                   class="subcategory-link text-decoration-none d-block">
                  {{ $subcategory->Name }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      @endforeach
    </div>

    <!-- Product Display + Tabs -->
    <div class="col-12 col-md-9">
      <ul class="nav table-nav-tabs">
        <li class="table-nav-item">
          <a class="table-nav-link active" onclick="loadProducts(currentSubcategoryId, 'Featured')">Featured</a>
        </li>
        <li class="table-nav-item">
          <a class="table-nav-link" onclick="loadProducts(currentSubcategoryId, 'New Arrivals')">New Arrival</a>
        </li>
        <li class="table-nav-item">
          <a class="table-nav-link" onclick="loadProducts(currentSubcategoryId, 'Best Sellers')">Best Sellers</a>
        </li>
      </ul>

      <div id="products-display" class="mt-3">
        <div id="default-message" class="text-center">
          <p class="text-muted">Select a category here to view products</p>
          <i class="fas fa-hand-point-left fa-2x text-primary"></i>
        </div>
      </div>
    </div>

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


let currentSubcategoryId = null; 
function toggleSubcategories(subcatId) {
        const element = document.getElementById(subcatId);
        const allSubcatElements = document.querySelectorAll('.subcategory-list');

        allSubcatElements.forEach(subcat => {
            if (subcat.id !== subcatId) {
                subcat.style.display = 'none';
                subcat.closest('.category-item').classList.remove('active');
            }
        });

        element.style.display = element.style.display === 'block' ? 'none' : 'block';
        const parentCategoryItem = element.closest('.category-item');
        if (parentCategoryItem) {
            parentCategoryItem.classList.toggle('active');
        }
    }
    function selectSubcategory(element, subcategoryId) {
    console.log("Selected Subcategory ID:", subcategoryId);
    currentSubcategoryId = subcategoryId; // Update the current subcategory ID

    // Remove the 'active' class from all subcategory links
    document.querySelectorAll('.subcategory-link').forEach(link => {
        link.classList.remove('active');
    });

    // Add the 'active' class to the clicked element
    element.classList.add('active');

    // Load products after setting the ID and updating the active class
    loadProducts(currentSubcategoryId, 'Featured');
}

    function loadProducts(currentSubcategoryId, type) {
        if (currentSubcategoryId === null) {
            console.error('Subcategory ID is not set.');
            return;
        }
        document.querySelectorAll('.table-nav-link').forEach(link => {
        link.classList.remove('active');
    });

    // Set active class on clicked tab - You need to pass the clicked element or find it
    // If you are using 'this' or an event object to identify the clicked tab, use it to add 'active'
    // For example, if `this` is the clicked element:
    event.target.classList.add('active');

        fetch(`/subcategories/${currentSubcategoryId}/products?type=${type}`)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('products-display');
        container.innerHTML = ''; // Clear existing content
        if (data.length > 0) {
            data.forEach(product => {
                container.innerHTML += `
                <a href="/subcategories/product/${product.ProductID}" class="card-link">
                    <div class="card mb-3">
                        <img src="/storage/${product.product_image}" class="card-img-top" alt="${product.Description}">
                        <div class="card-body text-center">
                            <h6 class="card-title">${product.Description}</h6>
                            <p class="card-text"><small class="text-muted">₹${product.SalePrice}</small></p>
                        </div>
                    </div>
                </a>
                `;
            });
            // Append View All button here, inside the check where products are found
           
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

