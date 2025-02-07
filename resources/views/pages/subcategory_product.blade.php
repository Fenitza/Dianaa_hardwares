@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <strong>{{ $subcategory->Name }}</strong><br>
            {{ $subcategory->Description }}
        </div>
        <div class="col-md-6 text-md-right">
            Sort by:
            <select class="custom-select d-inline w-auto" onchange="location = this.value;">
                <option value="?sort=best_match" {{ request()->query('sort') == 'best_match' ? 'selected' : '' }}>Best Match</option>
                <option value="?sort=price_low_high" {{ request()->query('sort') == 'price_low_high' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="?sort=price_high_low" {{ request()->query('sort') == 'price_high_low' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
            <button class="btn btn-outline-secondary ml-2">View Catalog</button>
            <button class="btn btn-outline-secondary ml-1">View List</button>
            <button class="btn btn-outline-secondary ml-1">View Grid</button>
        </div>
    </div>

 <!-- Product Grid -->
 <div class="product-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        @foreach ($products as $product)
        <div class="product">
        <div class ="row">
        <div class="col-md-4">
                    <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img" alt="{{ $product->Name }}">
        </div>

        <div class="col-md-8 d-flex flex-column product-info">
        <p><b>Dianaa Hardwares Part No.(SKU): </b><span style="color: blue;">{{ $product->SKU }}</span></p>
            <h4>{{ $product->Name }}</h4>
            <p>{{ $product->Description }}</p>
            <p><b>Manufacturer: </b>{{ $product->Manufacturer }}</p>
            <p><b>Online Price:</b> ₹{{ number_format($product->SalePrice, 2) }}</p>
        </div>
</div>
            <div class="product-actions" style="margin-top: 10px;">
            <div class="availability">
            <span class="{{ $product->Quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                {{ $product->Quantity > 0 ? 'In Stock' : 'Out of Stock' }}
            </span>
        </div>
        <div class="actions-right">
            <input type="number" value="1" min="1" name="quantity{{ $product->id }}" class="quantity-input">
            <button class="cart-btn">
                <i class="fas fa-shopping-cart"></i>
            </button>
        </div>
        </div>

        </div>
        @endforeach
    </div>
</div>
<script>
document.getElementById('sortProducts').addEventListener('change', function() {
    window.location.href = `{{ request()->url() }}?sort=${this.value}`;
});
</script>
@endsection