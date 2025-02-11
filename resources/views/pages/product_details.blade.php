@extends('layouts.app')

@section('content')
<div class="container">
    <div class="product-detail-page">
        <h2>{{ $product->Name }}</h2>
        <div class="row">
            <div class="col-md-6">
            <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img-top" alt="Product1">
            </div>
            <div class="col-md-6">
                <h3>Details</h3>
                <p><strong>SKU:</strong> {{ $product->SKU }}</p>
                <p><strong>Manufacturer:</strong> {{ $product->Manufacturer }}</p>
                <p><strong>Price:</strong> ₹{{ number_format($product->SalePrice, 2) }}</p>
                <p><strong>Availability:</strong> <span class="{{ $product->Quantity > 0 ? 'text-success' : 'text-danger' }}">{{ $product->Quantity > 0 ? 'In Stock' : 'Out of Stock' }}</span></p>
                <div class="mt-4">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" value="1" class="form-control w-auto">
                    <button class="btn btn-primary mt-3">Add to Cart</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
