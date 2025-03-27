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
 

    <!-- Product Categories -->
<div id="product-categories">
    
    <div class="tab-content" id="categoryContent">
        @foreach($categories as $index => $category)
        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="category{{ $category->CategoryID }}" role="tabpanel" aria-labelledby="category-tab-{{ $category->CategoryID }}">
            <div class="row justify-content-center">
                @foreach($category->subcategories as $subcategory)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="categ-card text-center">
                        <a href="{{ route('subcategory_product', ['subCategoryId' => $subcategory->SubCategoryID, 'manufacturer' => request()->manufacturer]) }}" class="card-link-category">
                            <div class="categ-card text-center">
                                <img src="{{ asset('storage/' . $subcategory->Image) }}" alt="{{ $subcategory->Name }}" class="product-img img-fluid" style="height: 100px;">
                                <div class="card-body">
                                    <p class="categ-card-title">{{ $subcategory->Name }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
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
