@extends('layouts.app')

@section('content')
<div class="container my-4" style="max-width: 1400px;">
    <div class="row">
        <input type="hidden" id="subcategory-id" value="{{ $subcategory->SubCategoryID }}">
        <!-- Filter Form -->
        <div class="col-md-3" id="filter-sidebar">
        <div class="row">
        <form id="filter-form" method="GET" action="{{ route('subcategory_product', ['subCategoryId' => $subcategory->SubCategoryID]) }}">
                    <div class="filter-section">
                        <h6>Filters</h6>

                        @foreach ([ 
    'brand' => 'Brand/Manufacturer',
    'size' => 'Thread Size',
    'length' => 'Length',
    'grade' => 'Grade',
    'color' => 'Colour',
    'pitch' => 'Pitch',
    'weight' => 'Weight',
    'type' => 'FT/HT',
    'metric' => 'MM or Inches',
    'threadtype' => 'UNC / UNF / BSF / BSW',
    'point' => 'Cone/Cup/Flat Points',
    'pitchtype' => 'Pitch Type'
] as $field => $label)
    <div class="filter-category ">
        <button type="button" class="collapsible btn btn-outline-dark w-100 ">{{ $label }}</button>
        <div class="content p-2 border" id="{{ strtolower($field) }}-container"></div>
    </div>
@endforeach


                        <div class="filter-controls col-md-12 mt-3">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <button type="submit" class="btn btn-success w-100" id="filter-apply">Apply Filters</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-secondary w-100" onclick="clearFilters()">Clear Filters</button>
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
                

                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-6">
                            <span style="color: grey; font-size: 14px;">({{ $products->total() }} Items)</span>
                            <select class="custom-select d-inline w-auto" id="perPage" onchange="changePerPage()">
                                <option value="12" {{ request()->query('perPage') == '12' ? 'selected' : '' }}>12 Per Page</option>
                                <option value="24" {{ request()->query('perPage') == '24' ? 'selected' : '' }}>24 Per Page</option>
                                <option value="48" {{ request()->query('perPage') == '48' ? 'selected' : '' }}>48 Per Page</option>
                            </select>
                        </div>
                        <div class="col-md-6 text-right">
                            Sort by:
                            <select class="custom-select d-inline w-auto" id="sortProducts">
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

                <!-- Conditionally Render Product Layout -->
                @if ($viewType == 'grid')
                    @include('partials.product_grid', ['products' => $products])
                @elseif ($viewType == 'list')
                    @include('partials.product_list', ['products' => $products])
                @elseif ($viewType == 'catalog')
                    @include('partials.product_catalog', ['products' => $products])
                @endif

                <div class="col-md-12 text-md-right d-flex align-items-center justify-content-center">
                    {{ $products->links('pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>

/* Filter section container */
.filter-section {
    font-size: 14px;
    padding: 10px;
    background-color: #f9f9f9;
    border-radius: 6px;
    border: 1px solid #ddd;
}

/* Collapsible filter buttons */
.filter-section .collapsible {
    font-size: 13px;
    font-weight: 500;
    width: 100%;
    background-color: #2a2f78;
    color: white;
    border: none;
    text-align: left;
    padding: 8px 12px;
    margin-bottom: 6px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.filter-section .collapsible:hover {
    background-color: #1d235a;
}

/* Active state */
.filter-section .collapsible.active {
    background-color: #a6ce39 !important;
    color: black;
}

/* Collapsible content */
.filter-section .content {
    display: none;
    padding: 6px 10px;
    border: 1px solid #ddd;
    background-color: white;
    margin-bottom: 10px;
    border-radius: 4px;
}

/* Checkbox styling */
.filter-section .form-check {
    margin-bottom: 5px;
    font-size: 13px;
}

.filter-section .form-check-input {
    margin-right: 6px;
}

<!-- Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetchFilters();
        initCollapsibles();

        document.getElementById('sortProducts').addEventListener('change', function() {
            let url = new URL(window.location.href);
            url.searchParams.set('sort', this.value);
            window.location.href = url.href;
        });
    });

    function fetchFilters() {
        const subCategoryId = document.getElementById('subcategory-id').value;
        fetch(`/filters?subcategory_id=${subCategoryId}`)
            .then(response => response.json())
            .then(data => {
                console.log("✅ Filter data:", data);
                Object.keys(data).forEach(key => {
                    const id = `${key.toLowerCase()}-container`;
                    populateFilters(data[key], id);
                });
            })
            .catch(error => console.error("❌ Error fetching filters:", error));
    }

    function populateFilters(items, containerId) {
        const container = document.getElementById(containerId);
        if (!container) {
            console.warn(`⚠️ Container not found: #${containerId}`);
            return;
        }

        container.innerHTML = '';
        items.forEach(item => {
            const div = document.createElement('div');
            div.className = 'form-check';

            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.className = 'form-check-input';
            checkbox.name = containerId.replace('-container', '') + '[]';
            checkbox.value = item.displayName;

            const label = document.createElement('label');
            label.className = 'form-check-label';
            label.appendChild(checkbox);
            label.append(" " + item.displayName);

            div.appendChild(label);
            container.appendChild(div);
        });
    }

    function clearFilters() {
        const url = new URL(window.location.href);
        url.search = '';
        window.location.href = url.href;
    }

    function initCollapsibles() {
        const collapsibles = document.getElementsByClassName("collapsible");
        for (let i = 0; i < collapsibles.length; i++) {
            collapsibles[i].addEventListener("click", function () {
                this.classList.toggle("active");
                const content = this.nextElementSibling;
                content.style.display = content.style.display === "block" ? "none" : "block";
            });
        }
    }
</script>
@endsection
