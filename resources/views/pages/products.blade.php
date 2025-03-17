@extends('layouts.app')

@section('content')
<div class="products-container">
    <!-- Product Tabs -->
    <ul class="nav nav-tabs" id="categoryTabs">
        @foreach($categories as $index => $category)
        <li class="nav-item">
            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="category-tab-{{ $category->CategoryID }}" data-bs-toggle="tab" href="#category{{ $category->CategoryID }}" role="tab" aria-controls="category{{ $category->CategoryID }}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">{{ $category->Name }}</a>
        </li>
        @endforeach
    </ul>
    <!-- Spacer Block -->
    <div class="custom-spacer" style="height: 20px;"></div>

    <!-- Product Categories -->
    <div class="container my-4">
        <h3 class="text-center mb-3" style="color: #2d2e6a">PRODUCT CATEGORIES</h3>
        <div class="tab-content" id="categoryContent">
            @foreach($categories as $index => $category)
            <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="category{{ $category->CategoryID }}" role="tabpanel" aria-labelledby="category-tab-{{ $category->CategoryID }}">
                <div class="row justify-content-center">
                    @foreach($category->subcategories as $subcategory)
                    <div class="col-9 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <a href="{{ route('subcategory_product', ['subCategoryId' => $subcategory->SubCategoryID, 'manufacturer' => request()->manufacturer]) }}">
                            <div class="card-category text-center">
                                <img src="{{ asset('storage/' . $subcategory->Image) }}" alt="{{ $subcategory->Name }}" class="product-img img-fluid"
                                style="width: auto; height: 150px; margin: 0 auto 20px; object-fit: contain;">
                                <div class="card-body">
                                    <p class="card-text-category">{{ $subcategory->Name }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let urlParams = new URLSearchParams(window.location.search);
    let activeCategory = urlParams.get('category');
    if (activeCategory) {
        let tabElement = document.querySelector(`#category-tab-${activeCategory}`);
        if (tabElement) {
            new bootstrap.Tab(tabElement).show(); // This ensures that Bootstrap 5 tabs work with dynamic activation
        }
    }
});
</script>

@endsection
