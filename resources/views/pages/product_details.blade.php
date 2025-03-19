@extends('layouts.app')

@section('content')
<!-- Spacer Block -->
<div class="custom-spacer"></div>

<div class="container">
    <div class="row product-detail-page" >
        <!-- First Column: Product Image -->
        <div class="col-md-4" style="margin-top: 50px; ">
        <img src="{{ asset('storage/' . $product->product_image) }}" alt="Product_Image" class="product-img" 
            style="width: 100%; height: auto; position:contain;">
        </div>

        <!-- Second Column: Product Details and Attributes -->
<!-- Product Details -->
        <div class="col-md-8 my-4">
            <div class="product-details">
                <h1>{{ $product->Name }}</h1>
                <div class="details-block">
                    <div><strong>Part No. (SKU):</strong> {{ $product->SKU }}</div>
                    <div><strong>Description:</strong> {{ $product->Description }}</div>
                    <div><strong>Standard:</strong> {{ $product->Standard }}</div>
                    <div><strong>Manufacturer:</strong> {{ $product->manufacturer->Name ?? 'No Manufacturer' }}</div>
                    <div class="catalog-item">This is a Catalog Item</div>
                </div>
                <div class="attributes-block">
                    <h3>Product Attributes</h3>
                    <div><strong>Size:</strong> {{ $product->Size }}</div>
                    <div><strong>Length:</strong> {{ $product->Length }}</div>
                    <div><strong>Material:</strong> {{ $product->Material }}</div>
                    <div><strong>Type:</strong> {{ $product->Type }}</div>
                    <div><strong>Color:</strong> {{ $product->Color }}</div>
                    <div><strong>Property Class:</strong> {{ $product->Property_Class }}</div>
                </div>
            </div>
      
        <!-- Third Column: Pricing and Supply Chain -->
        <div class="col-md-4" style="margin-top: 50px;">
            <h3>Price</h3>
            <p><strong>Online Price:</strong> ₹{{ number_format($product->SalePrice, 2) }}</p>
            <div class="quantity mb-3">
                <label for="quantity"><strong>Quantity:</strong></label>
                <input type="number" id="quantity" name="quantity" min="1" value="1" class="form-control w-auto">
            </div>

            <div class="catalog-item">Special discount for vendors! Checkout to explore!</div>
            

            @if (auth()->check())
        <button class="btn btn-primary mb-3 btn-add-to-cart" data-product-id="{{ $product->ProductID }}" data-cart-add-url="{{ route('cart.add') }}">Add to Cart</button>
        <!-- Bulk Order Button -->
        <button class="btn btn-secondary mb-3 btn-bulk-order" data-bs-toggle="modal"data-product-id="{{ $product->ProductID }}"
        data-user-name="{{ auth()->user()->name }}"
        data-user-email="{{ auth()->user()->email }}"
        data-user-phone="{{ auth()->user()->phone_number }}"
         data-bs-target="#bulkOrderModal">Request Bulk Order</button>

        <!-- Bulk Order Modal -->
        <div class="modal fade" id="bulkOrderModal" tabindex="-1" aria-labelledby="bulkOrderModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bulkOrderModalLabel">Bulk Order Request</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <form id="bulkOrderForm" data-product-id="{{ $product->ProductID }}"
                        data-user-name="{{ auth()->user()->name }}"
                        data-user-email="{{ auth()->user()->email }}"
                        data-user-phone="{{ auth()->user()->phone_number }}">
                        <div class="mb-3">
                                <label for="bulkQuantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="bulkQuantity" name="quantity" min="1" value="10">
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Additional Message</label>
                                <textarea class="form-control" id="message" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Request</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Link to the login page if the user is not authenticated -->
        <a href="{{ route('login') }}?redirect_to={{ url()->current() }}" class="btn btn-primary mb-3 btn-add-to-cart">Sign in to add to cart</a>
        <a href="{{ route('login') }}?redirect_to={{ url()->current() }}" class="btn btn-secondary mb-3">Sign in to request bulk order</a>
        @endif
    
            <ul class="list-unstyled">
<li class="product-attributes-heading"><strong>Supply Chain</strong></li>
                <p><strong>Availability:</strong> <span class="{{ $product->Quantity > 0 ? 'text-success' : 'text-danger' }}">{{ $product->Quantity > 0 ? 'In Stock' : 'Out of Stock' }}</span></p>
                <p><strong>Supply Chain Info:</strong> {{ $product->SupplyChain }}</p>
                <p><strong>Direct Ship:</strong> Ships {{ $product->ShipDate }}</p>

</ul>
            
        </div>
    </div>
</div>
@endsection

