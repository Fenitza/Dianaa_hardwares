@extends('layouts.app')

@section('content')
<!-- Spacer Block -->
<div class="custom-spacer"></div>

<div class="container">
    <div class="row product-detail-page" >
        <!-- First Column: Product Image -->
        <!-- <div class="col-md-4" style="margin-top: 50px; ">
        <img src="{{ asset('storage/' . $product->product_image) }}" alt="Product_Image" class="product-img" 
            style="width: 100%; height: auto; position:contain;">
        </div> -->

        <!-- First Column: Product Image Carousel -->
        <!-- Only show the carousel if there are image paths -->
         <div class="col-md-4" style="margin-top: 50px; ">
        @if(!empty($product->image_paths) && is_array($product->image_paths))
            <div class="col-md-8 offset-md-2">
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                    <!-- Indicators/dots -->
                    <ol class="carousel-indicators">
                        @foreach($product->image_paths as $index => $imagePath)
                            <li data-bs-target="#productCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                        @endforeach
                    </ol>

                    <!-- The slideshow/images -->
                    <div class="carousel-inner">
                        @foreach($product->image_paths as $index => $imagePath)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $imagePath) }}" class="d-block w-100" alt="Product Image {{ $index + 1 }}">
                            </div>
                        @endforeach
                    </div>

                    <!-- Left and right controls/icons -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        @else
            <p>No images available for this product.</p>
        @endif
</div>
            

        <!-- Second Column: Product Details and Attributes -->
<!-- Product Details -->
        <div class="col-md-4 product-details">
            <h2>{{ $product->Name }}</h2>
            <ul class="list-unstyled" style="font-size:12px;">
                <li><strong>Dianaa Fasteners Part No. (SKU):</strong> {{ $product->SKU }}</li>
                <li><strong>Description:</strong> {{ $product->Description }}</li>
                <li><strong>Standard:</strong> {{ $product->Standard }}</li>
                <li><strong>Manufacturer:</strong> {{ $product->manufacturer->Name ?? 'No Manufacturer' }}</li>
                <li><div class="catalog-item">This is a Catalog Item</div></li>
                <li class="product-attributes-heading"><strong>Product Attributes</strong></li>
                <li><strong>Size:</strong> {{ $product->Size }}</li>
                <li><strong>Length:</strong> {{ $product->Length }}</li>
                <li><strong>Material:</strong> {{ $product->Material }}</li>
                <li><strong>Type:</strong> {{ $product->Type }}</li>
                <li><strong>Color:</strong> {{ $product->Color }}</li>
                <li><strong>Property Class:</strong> {{ $product->Property_Class }}</li>
            </ul>
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

