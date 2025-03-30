@extends('layouts.app')

@section('content')
<div class="container my-4" style="max-width: 1400px;">
    <div class="row">
        <input type="hidden" id="subcategory-id" value="{{ $subcategory->SubCategoryID }}">
        <!-- Filter Column -->
        <div class="col-md-3" id="filter-sidebar">
            <div class="row">
                <!-- First column of filters -->
                <form id="filter-form" method="GET" action="{{ route('subcategory_product', ['subCategoryId' => $subcategory->SubCategoryID, 'brand' => request()->brand]) }}">
                <div class="filter-section">
                    <h6>Filters</h6>
                    <div class="filter-category">
                        <button type="button" class="collapsible">Brand/Manufacturer</button>
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
                    <div class="filter-controls col-md-12 justify-content-center">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success" id="filter-apply">Apply Filters</button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-secondary" id="filter-apply" onclick="clearFilters()">Clear Filters</button>
                        </div>
                    </div>
                </div>
</div>
            </form>

            </div>

        </div>
    
        <!-- Product Grid Column -->
        <div class="col-md-9">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <strong>{{ $subcategory->Name }}</strong><br>
                    {{ $subcategory->Description }}
                    
                </div>

                <!-- Product Grid -->
                <div class="col-md-12">
    <div class="row justify-content-between align-items-center">
        <!-- Items and Per Page Selection -->
        <div class="col-md-6">
           
            <span style="color: grey; font-size: 14px;">({{ $products->total() }} Items)</span>
            
            <select class="custom-select d-inline w-auto" id="perPage" onchange="changePerPage()">
                <option value="12" {{ request()->query('perPage') == '12' ? 'selected' : '' }}>12 Per Page</option>
                <option value="24" {{ request()->query('perPage') == '24' ? 'selected' : '' }}>24 Per Page</option>
                <option value="48" {{ request()->query('perPage') == '48' ? 'selected' : '' }}>48 Per Page</option>
            </select>
        </div>

        <!-- Sort and View Options -->
        <div class="col-md-6 text-right">
            Sort by:
            <select class="custom-select d-inline w-auto" id="sortProducts" onchange="updateSortAndView(this.value)">
                <option value="best_match" {{ request()->query('sort') == 'best_match' ? 'selected' : '' }}>Best Match</option>
                <option value="price_low_high" {{ request()->query('sort') == 'price_low_high' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high_low" {{ request()->query('sort') == 'price_high_low' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
            <div class="view-links d-inline">
                <a href="{{ request()->fullUrlWithQuery(['view' => 'catalog']) }}" class="view-link">Catalog View |</a>
                <a href="{{ request()->fullUrlWithQuery(['view' => 'list']) }}" class="view-link">List View |</a>
                <a href="{{ request()->fullUrlWithQuery(['view' => 'grid']) }}" class="view-link">Grid View</a>
            </div>
        </div>
    </div>

</div>

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

    handleFilterChanges();
});

function fetchFilters() {
    fetch('/filters')
        .then(response => response.json())
        .then(data => {
            console.log('Received filter data:', data);  // Ensure data is logged
            populateFilters(data.brands, 'brand-container');
            populateFilters(data.materials, 'material-container');
            populateFilters(data.sizes, 'size-container');
            populateFilters(data.lengths, 'length-container');
            populateFilters(data.standards, 'standard-container');
            populateFilters(data.colors, 'color-container');
            populateFilters(data.property, 'propertyClass-container');
        })
        .catch(error => {
            console.error('Error loading filter data:', error);
        });
}

function populateFilters(items, containerId) {
    const container = document.getElementById(containerId);
    if (!container) {
        console.error('Container not found:', containerId);
        return; // Exit if container is not found
    }

    container.innerHTML = ''; // Clear existing contents
    console.log(`Populating ${containerId} with`, items);  // Log what's being populated

    items.forEach(item => {
        if (!item.displayName) {
            console.error('Invalid item:', item);
            return; // Skip this item if it's not correctly formatted
        }
        
        const div = document.createElement('div');
        const label = document.createElement('label');
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.value = item.displayName;
        checkbox.name = containerId.replace('-container', '') + '[]';  // Correct name for array format
        label.appendChild(checkbox);
        label.append(' ' + item.displayName);
        div.appendChild(label);
        container.appendChild(div);
    });
}

function clearFilters() {
    const url = new URL(window.location);
    url.search = '';
    window.location.href = url;
}

document.querySelectorAll('[name="brand-container[]"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        updateUrlWithFilters();
    });
});

function updateUrlWithFilters() {
    let searchParams = new URLSearchParams(window.location.search);
    let brands = [];
    document.querySelectorAll('[name="brand-container[]"]:checked').forEach(checkbox => {
        brands.push(checkbox.value);
    });
    if (brands.length > 0) {
        searchParams.set('brand', brands.join(','));
    } else {
        searchParams.delete('brand');
    }
    window.location.search = searchParams.toString(); // Update the page with new query string
}


// function handleFilterChanges() {
//     const filterForm = document.getElementById('filter-form');
//     filterForm.addEventListener('change', function() {
//         this.submit();  // Submit the form on any checkbox change
//     });
// }
</script>


@endsection