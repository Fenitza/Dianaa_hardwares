@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Product Tabs -->
    <ul class="nav nav-tabs" id="categoryTabs">
        @foreach($categories as $index => $category)
        <li class="nav-item">
            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="category-tab-{{ $category->CategoryID }}" data-bs-toggle="tab" href="#category{{ $category->CategoryID }}" role="tab" aria-controls="category{{ $category->CategoryID }}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">{{ $category->Name }}</a>
        </li>
        @endforeach
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="categoryContent">
        @foreach($categories as $index => $category)
        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="category{{ $category->CategoryID }}" role="tabpanel" aria-labelledby="category-tab-{{ $category->CategoryID }}">
            <h4>{{ $category->Name }} Subcategories</h4>
            <ul>
                @foreach($category->subcategories as $subcategory)
                <li>{{ $subcategory->Name }}</li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>
</div>
@endsection
