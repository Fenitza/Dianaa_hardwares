@extends('layouts.app')
<title>{{$subcategory->Name}} - Dianaa Fasteners</title>

@section('content')
<div class="container my-3" style="max-width: 1400px;">
    <div class="row">
        <input type="hidden" id="subcategory-id" value="{{ $subcategory->SubCategoryID }}">

        <!-- Mobile Filter Toggle -->
        <div class="col-12 d-md-none mb-3">
            <button class="btn btn-outline-dark w-100" type="button" data-bs-toggle="collapse" data-bs-target="#filter-sidebar" aria-expanded="false" aria-controls="filter-sidebar">
                Toggle Filters
            </button>
        </div>

        <!-- Filter Form -->
        <div class="col-12 col-md-3 collapse d-md-block mb-3" id="filter-sidebar">
            <div class="row">
                @php
                    $query = ['brand' => request()->input('brand', [])];
                @endphp

                <a href="{{ route('subcategory_product', ['subCategoryId' => $subcategory->SubCategoryID]) }}?{{ http_build_query($query) }}"></a>

                <div class="filter-section">
                    <h6>Filters</h6>
                    @foreach ([ 
                        'brand' => 'Brand/Manufacturer',
                        'size' => 'Thread Size',
                        'length' => 'Length',
                        'grade' => 'Grade',
                        'pitch' => 'Pitch',
                        'weight' => 'Weight',
                        'type' => 'Type',
                        'standardType' => 'UNC / UNF / BSF / BSW',
                        'metric' => 'MM or Inches',
                        'threadtype' => 'Thread type',
                        'point' => 'Cone/Cup/Flat Points',
                        'pitchtype' => 'Pitch Type'
                        ] as $field => $label)
                        <div class="filter-category">
                            <button type="button" class="collapsible btn btn-outline-dark w-100">{{ $label }}</button>
                            <div class="content p-2 border" id="{{ strtolower($field) }}-container"></div>
                        </div>
                    @endforeach

                    <div class="filter-controls mt-3">
                        <div class="row g-4">
                            <div class="col-6">
                                <button type="submit" class="btn w-100" id="filter-apply">Apply Filters</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn w-100" onclick="clearFilters()">Clear Filters</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Grid Column -->
        <div class="col-12 col-md-9">
            <div class="row align-items-center">
                <div class="col-12 mb-3">
                    <strong>{{ $subcategory->Name }}</strong><br>
                    {{ $subcategory->Description }}
                </div>

                <div class="col-12 mb-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-6">
                            <span style="color: grey; font-size: 14px;">({{ $products->total() }} Items)</span>
                            <select class="custom-select d-inline w-auto" id="perPage" onchange="changePerPage()">
                                <option value="12" {{ request()->query('perPage') == '12' ? 'selected' : '' }}>12 Per Page</option>
                                <option value="24" {{ request()->query('perPage') == '24' ? 'selected' : '' }}>24 Per Page</option>
                                <option value="48" {{ request()->query('perPage') == '48' ? 'selected' : '' }}>48 Per Page</option>
                            </select>
                        </div>
                        <div class="col-md-6 text-md-right mt-2 mt-md-0">
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

                <div class="col-12 text-center mt-4">
                    {{ $products->links('pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>
<style>
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


.filter-controls .btn {
    font-size: 14px;
    padding: 10px 12px;
    border-radius: 6px;
    transition: background-color 0.2s ease;
}

/* Apply Button */
#filter-apply {
    background-color: #b3d334;
    border: none;
    color: #000;
}

#filter-apply:hover {
    background-color: #a1c425;
}

/* Clear Button */
.filter-controls .btn-secondary {
    background-color: #5c6670;
    color: white;
    border: none;
}

.filter-controls .btn-secondary:hover {
    background-color: #495057;
}
@media (max-width: 768px) {
        .filter-section {
            margin-bottom: 15px;
        }

        .view-links {
            display: block;
            margin-top: 10px;
        }

        .filter-controls .btn {
            padding: 8px 10px;
        }
    }

</style>


@endsection
