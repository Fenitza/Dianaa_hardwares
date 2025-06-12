@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h1 class="search-title">Search Results for '{{ request('q') }}'</h1>
    <div class="results-container">
        @if($subcategories->isNotEmpty())
            <div class="results-column">
                <h2 class="results-heading">Subcategories</h2>
                <ul class="list-unstyled results-list">
                    @foreach($subcategories as $subcategory)
                        <li class="list-item">
                            <a href="{{ url('/subcategories', $subcategory->SubCategoryID) }}">{{ $subcategory->Name }}</a>
                        </li>
                    @endforeach 
                </ul>
            </div>
        @endif

        @if($products->isNotEmpty())
            <div class="results-column">
                <h2 class="results-heading">Products</h2>
                <ul class="list-unstyled results-list">
                    @foreach($products as $product)
                        <li class="list-item">
                            <a href="{{ route('product.details', ['ProductID' => $product->ProductID]) }}">{{ $product->Description }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($manufacturers->isNotEmpty())
            <div class="results-column">
                <h2 class="results-heading">Manufacturers</h2>
                <ul class="list-unstyled results-list">
                    @foreach($manufacturers as $manufacturer)
                        <li class="list-item">
                            <a href="{{ route('products_main', ['manufacturer' => $manufacturer->ManufacturerID]) }}">{{ $manufacturer->Name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
@endsection



<style>
    .container {
        max-width: 90%;
        margin: auto;
        padding-top: 20px;
        font-family: Arial, sans-serif;
    }

    .search-title {
        color: #2a2e6a;
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 30px;
    }

    .results-heading {
        font-size: 0.8rem;
        color: #2a2e6a;
        border-bottom: 2px solid #A5CD36;
        padding-bottom: 5px;
        margin-bottom: 15px;
    }

    .results-container {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .results-column {
        flex: 1;
        background-color: #f9f9f9;
        border: 1px solid #D3D3D3;
        padding: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        border-radius: 5px;
    }

    .results-list {
        list-style-type: none;
        padding: 0;
    }

    .list-item {
        border-bottom: 1px solid #D3D3D3;
        margin-bottom: 5px; /* Reduced margin for more compact listing */
    }

    .list-item:last-child {
        border-bottom: none;
    }

    .list-item a {
        display: block;
        padding: 5px 12px; /* Reduced padding for less space between lines */
        color: #2a2e6a;
        text-decoration: none;
        transition: background-color 0.2s, color 0.2s;
        line-height: 1.3; /* Reduced line height for a more compact look */
    }

    .list-item a:hover, .list-item a:focus {
        background-color: #A5CD36;
        color: #2d2e6a;
        text-decoration: none;
    }
</style>

