@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row">
        <!-- Filter Column -->
        <div class="col-md-3">
            <div class="row">
                <!-- First column of filters -->
                <form id="filter-form">
                <div class="col-md-8">
                    <p><strong>Filter By:</strong></p>
                    <h6>My Availability</h6>
                    <div>
                        <input type="checkbox" id="availability" name="availability">
                        <label for="availability">Available Only</label>
                    </div>
                    <h6>Brand / Manufacturer</h6>
                        @if($products->pluck('Manufacturer')->unique()->isNotEmpty())
                            @foreach($products->pluck('Manufacturer')->unique() as $manufacturer)
                            <div>
                                <input type="checkbox" id="manufacturer_{{ $manufacturer }}" name="manufacturer[]" value="{{ $manufacturer }}">
                                <label for="manufacturer_{{ $manufacturer }}">{{ $manufacturer }}</label>
                            </div>
                            @endforeach
                        @else
                            <p>No manufacturers available</p>
                        @endif

                        <h6>Material</h6>
                        @if($products->pluck('Material')->unique()->isNotEmpty())
                            @foreach($products->pluck('Material')->unique() as $material)
                            <div>
                                <input type="checkbox" id="material_{{ $material }}" name="material[]" value="{{ $material }}">
                                <label for="material_{{ $material }}">{{ $material }}</label>
                            </div>
                            @endforeach
                        @else
                            <p>No materials available</p>
                        @endif
                        <button type="button" onclick="submitFilters()">Apply Filters</button>
                        </form>
                </div>
                
                
            </div>
        </div>
    
        <!-- Product Grid Column -->
        <div class="col-md-9">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <strong>{{ $subcategory->Name }}</strong><br>
                    {{ $subcategory->Description }}
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
            <!-- Conditionally render the product layout -->
            @if ($viewType == 'grid')
                @include('partials.product_grid', ['products' => $products])
            @elseif ($viewType == 'list')
                @include('partials.product_list', ['products' => $products])
            @elseif ($viewType == 'catalog')
                @include('partials.product_catalog', ['products' => $products])
            @endif
        </div>
    </div>
</div>

 
@include('partials.product_detail_modal') <!-- Include modal as a partial -->

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

<!-- catalog popup -->
<script>
function showProductDetails(productId) {
    // AJAX call to fetch product details and populate the modal
    // Then show the modal
    $('#productDetailModal').modal('show');
}
</script>

<!-- filter -->
<script>
function submitFilters() {
    const formData = new FormData(document.getElementById('filter-form'));

    fetch('{{ route('subcategory.filter', ['subCategoryId' => $subcategory->SubCategoryID]) }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('product-list').innerHTML = data.html;
    })
    .catch(error => console.error('Error:', error));
}
</script>

@endsection