@extends('layouts.app')

@section('content')
<div class="container my-4" style="max-width: 1400px;">
    <div class="row">
        <!-- Filter Column -->
        <div class="col-md-3" id="filter-sidebar">
            <div class="row">
                <!-- First column of filters -->
                <form id="filter-form">
                <div class="filter-section">
                    <h6>Filters</h6>
                    <div class="filter-category">
                        <button type="button" class="collapsible">Brand / Manufacturer</button>
                        <div class="content" id="brand-container"></div>
                    </div>

                    <div class="filter-category">
                        <button type="button" class="collapsible">Material</button>
                        <div class="content" id="material-container"></div>
                    </div>

                    <div class="filter-category">
                        <button type="button" class="collapsible">Size</button>
                        <div class="content" id="size-container"></div>
                    </div>

                    <div class="filter-category">
                        <button type="button" class="collapsible">Length</button>
                        <div class="content" id="length-container"></div>
                    </div>

                    <div class="filter-category">
                        <button type="button" class="collapsible">Standard</button>
                        <div class="content" id="standard-container"></div>
                    </div>

                    <div class="filter-category">
                        <button type="button" class="collapsible">Color</button>
                        <div class="content" id="color-container"></div>
                    </div>

                    <div class="filter-category">
                        <button type="button" class="collapsible">Property Class</button>
                        <div class="content" id="propertyClass-container"></div>
                    </div>

                    <button type="button" id="filter-apply" onclick="submitFilters()" class="btn btn-primary mt-3">Apply Filters</button>
                </div>
            </form>

            </div>

        </div>
    
        <!-- Product Grid Column -->
        <div class="col-md-9">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <strong>{{ $subcategory->Name }}</strong><br>
                    {{ $subcategory->Description }}
                </div>

                <!-- Product Grid -->
                <div class="row align-items-center" style ="font=size:12px;">
                <div class="col-md-12 text-md-right d-flex align-items-center justify-content-between">
                    <!-- Items and Per Page Selection -->
                    <div>
                        <span>({{ $products->total() }} Items)</span>
                        <select class="custom-select d-inline w-auto" id="perPage" onchange="changePerPage()">
                            <option value="1" {{ request()->query('perPage') == '1' ? 'selected' : '' }}>1 Per Page</option>
                            <option value="2" {{ request()->query('perPage') == '2' ? 'selected' : '' }}>2 Per Page</option>
                            <option value="3" {{ request()->query('perPage') == '3' ? 'selected' : '' }}>3 Per Page</option>
                        </select>
                    </div>
                </div>
            </div>
            
                <div class="col-md-12 text-md-right d-flex align-items-center justify-content-end">
                    Sort by:
                    <select class="custom-select d-inline w-auto" id="sortProducts" onchange="updateSortAndView(this.value)">
                        <option value="best_match" {{ request()->query('sort') == 'best_match' ? 'selected' : '' }}>Best Match</option>
                        <option value="price_low_high" {{ request()->query('sort') == 'price_low_high' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high_low" {{ request()->query('sort') == 'price_high_low' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                    <div class="view-links ml-2">
                        <a href="{{ request()->fullUrlWithQuery(['view' => 'catalog']) }}" class="view-link">Catalog View |</a>
                        <a href="{{ request()->fullUrlWithQuery(['view' => 'list']) }}" class="view-link">List View |</a>
                        <a href="{{ request()->fullUrlWithQuery(['view' => 'grid']) }}" class="view-link">Grid View</a>
                    </div>
                </div>

            <hr>
            <!-- Spacer Block -->
            <div class="custom-spacer" style="height: 10px;"></div>
            <!-- Conditionally render the product layout -->
            @if ($viewType == 'grid')
                @include('partials.product_grid', ['products' => $products])
            @elseif ($viewType == 'list')
                @include('partials.product_list', ['products' => $products])
            @elseif ($viewType == 'catalog')
                @include('partials.product_catalog', ['products' => $products])
            @endif
            <!-- Spacer Block -->
            <div class="custom-spacer" style="height: 10px;"></div>
             <div class="col-md-12 text-md-right d-flex align-items-center justify-content-center">
                {{ $products->links('pagination.custom') }}
            </div>
        </div>
    </div>
    </div>
    </div>

    





<!-- Sort Script -->
<script>
document.getElementById('sortProducts').addEventListener('change', function() {
    let newSort = this.value;
    let currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('sort', newSort);
    // Ensure the view parameter is maintained
    let currentView = currentUrl.searchParams.get('view') || 'grid'; // default to grid if none
    currentUrl.searchParams.set('view', currentView);
    window.location.href = currentUrl.href;
});
</script>

<!-- Views Script -->
<script>
function updateView(type, value) {
    let params = new URLSearchParams(window.location.search);
    params.set(type, value);
    window.location.href = window.location.pathname + '?' + params.toString();
}
</script>

<!-- filter -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var coll = document.getElementsByClassName("collapsible");
    for (var i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }

    fetchFilters();  // Fetch filters on page load
});


function fetchFilters() {
    fetch('/filters')
    .then(response => response.json())
    .then(data => {
    console.log('Received data:', data);
        populateFilters(data.brands, 'brand-container');
        populateFilters(data.materials, 'material-container');
        populateFilters(data.sizes, 'size-container');
        populateFilters(data.lengths, 'length-container');
        populateFilters(data.standards, 'standard-container');
        populateFilters(data.colors, 'color-container');
        populateFilters(data.property, 'propertyClass-container');
    })
    .catch(error => console.error('Error loading filter data:', error));
}

function populateFilters(items, containerId) {
    const container = document.getElementById(containerId);
    items.forEach(item => {
        const div = document.createElement('div');
        const label = document.createElement('label');
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.value = item.displayName; // Adjust this field name based on a standard attribute passed from the server
        checkbox.name = containerId;
        label.appendChild(checkbox);
        label.append(item.displayName); // Use displayName for uniformity
        div.appendChild(label);
        container.appendChild(div);
    });
}

function submitFilters() {
    const formData = new FormData(document.getElementById('filter-form'));
    for (let entry of formData.entries()) {
        console.log(entry[0], entry[1]); // Log each key and value
    }
    fetch('/api/applyFilters/{$subcategory->SubCategoryID}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/x-www-form-urlencoded',
        },
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        // Update the UI with the filtered products
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to apply filters. Please try again!');
    });
}

</script>

@endsection