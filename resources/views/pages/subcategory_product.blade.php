@extends('layouts.app')

@section('content')

<div class="product-detailed">
    <div class="row align-items-center">
        <div class="col-md-6">
            <p><strong>{{ $subcategory->Name }}</strong><br>
            {{ $subcategory->Description }}</p>
        </div>
        <div class="col-md-6 text-md-right">
            <span>Sort by:</span>
            <select class="custom-select d-inline w-auto">
                <option value="best_match">Best Match</option>
                <option value="price_low_high">Price: Low to High</option>
                <option value="price_high_low">Price: High to Low</option>
            </select>
            <button class="btn btn-outline-secondary ml-2">View Catalog</button>
            <button class="btn btn-outline-secondary ml-1">View List</button>
            <button class="btn btn-outline-secondary ml-1">View Grid</button>
        </div>
    </div>

    <!-- view -->
    <div class="row mt-4">
    @foreach ($products as $product)
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="row no-gutters">
                <div class="col-md-6">
                    <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img" alt="{{ $product->Name }}">
                </div>
                <div class="col-md-6 d-flex flex-column">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->Name }}</h5>
                        <p class="card-text">{{ $product->Description }}</p>
                        <p class="card-text">${{ $product->SalePrice }}</p>
                    </div>
                </div>
                    <div class="card-footer bg-white border-top-0 mt-auto">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $product->Availability ? 'In Stock' : 'Out of Stock' }}</small>
                            <div class="quantity-controls d-flex align-items-center mr-2">
                                <button class="btn btn-outline-secondary btn-sm" onclick="changeQuantity('dec', '{{ $product->id }}')">-</button>
                                <input type="text" id="quantity-{{ $product->id }}" value="1" class="form-control text-center" style="width: 50px;">
                                <button class="btn btn-outline-secondary btn-sm" onclick="changeQuantity('inc', '{{ $product->id }}')">+</button>
                        </div>
                            <a href="#" class="btn btn-primary">Add to Cart</a>
                        </div>
                    </div>
                
            </div>
        </div>
    </div>
    @endforeach
</div>


</div>
<script>
    function changeQuantity(action, productId) {
    var input = document.getElementById('quantity-' + productId);
    var currentValue = parseInt(input.value, 10);

    if (action === 'inc') {
        currentValue++;
    } else if (action === 'dec' && currentValue > 1) {
        currentValue--;
    }

    input.value = currentValue;
}
</script>
@endsection