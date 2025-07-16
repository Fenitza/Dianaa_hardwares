<div class="col-md-12">
    <div class="product-grid" id="product-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        @foreach ($products as $product)
            <div class="product p-2 border shadow-sm rounded bg-white">
                <div class="row align-items-center flex-nowrap flex-md-wrap">
                    <!-- Image Section -->
                    <div class="col-4">
                        <img src="{{ asset('storage/' . $product->product_image) }}" alt="Product Image" class="card-img-top product-image"
                             onclick="window.location.href='{{ route('product.details', ['ProductID' => $product->ProductID]) }}'"
                             style="cursor: pointer;">
                    </div>
                    <!-- Content Section -->
                    <div class="col-8 d-flex flex-column product-info">
                        <p><b>Dianaa Fasteners Part No.(SKU): </b><span style="color: blue;">{{ $product->SKU }}</span></p>
                        <h4>{{ $product->Name }}</h4>
                        <p>{{ $product->Description }}</p>
                        <p><b>Manufacturer: </b>{{ $product->manufacturer->Name }}</p>
                        <p><b>Online Price:</b> ₹{{ number_format($product->colorVariants->first()->online_price ?? $product->SalePrice, 2) }}</p>
                    </div>
                </div>

                <!-- Actions Section -->
                <div class="product-actions mt-2 d-flex justify-content-between align-items-center">
                    <span class="{{ $product->Quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                        {{ $product->Quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                    <div class="actions-right d-flex align-items-center">
                        <!-- <input type="number" value="1" min="1" name="quantity{{ $product->ProductID }}" id="quantity" class="quantity-input form-control form-control-sm me-2">
                        @if (auth()->check())
                            <button class="btn btn-primary btn-sm btn-add-to-cart" data-product-id="{{ $product->ProductID }}" data-cart-add-url="{{ route('cart.add') }}">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        @else
                            <a href="{{ route('login') }}?redirect_to={{ url()->current() }}" class="btn btn-primary btn-sm btn-add-to-cart">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        @endif -->
                        <a href="{{ route('product.details', ['ProductID' => $product->ProductID]) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
.product-image {
    max-width: 100%;
    max-height: 120px;
    object-fit: contain;
}

.quantity-input {
    width: 60px;
    text-align: center;
}

@media (max-width: 768px) {
    .product-grid {
        grid-template-columns: repeat(1, 1fr) !important;
    }

    .product .row {
        flex-wrap: nowrap !important;
    }

    .product-image {
        max-width: 80px !important;
        max-height: 80px !important;
    }

    .product-info p, .product-info h4 {
        font-size: 12px !important;
        margin-bottom: 4px !important;
    }

    .quantity-input {
        width: 50px !important;
        height: 30px !important;
    }

    .product-actions span {
        font-size: 12px !important;
    }

    .btn-add-to-cart {
        padding: 4px 8px !important;
        font-size: 12px !important;
    }
}

@media (max-width: 480px) {
    .product-image {
        max-width: 60px !important;
        max-height: 60px !important;
    }

    .product-info p, .product-info h4 {
        font-size: 11px !important;
    }

    .quantity-input {
        width: 45px !important;
        height: 28px !important;
    }

    .product-actions span {
        font-size: 11px !important;
    }
}
</style>
