@extends('layouts.app')

@section('content')
<!-- Spacer Block -->
<div class="custom-spacer"></div>

<div class="product-detail-container">
    <div class="row product-detail-page" >
        <!-- First Column: Product Image -->
        <!-- <div class="col-md-4" style="margin-top: 50px; ">
        <img src="{{ asset('storage/' . $product->product_image) }}" alt="Product_Image" class="product-img" 
            style="width: 100%; height: auto; position:contain;">
        </div> -->

        <!-- Product Image Carousel -->
        <div class="col-md-4" style="margin-top: 50px;">
            @if(!empty($product->image_paths) && is_array($product->image_paths))
<div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
    <!-- Indicators/dots -->
    <ol class="carousel-indicators">
        @foreach($product->image_paths as $key => $imagePath)
            <li data-bs-target="#productCarousel" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
        @endforeach
    </ol>

    <!-- The slideshow/images -->
    <div class="carousel-inner">
        @foreach($product->image_paths as $key => $imagePath)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <img src="{{ asset('storage/' . $imagePath) }}" class="d-block w-100" alt="Image">
            </div>
        @endforeach
    </div>

    <!-- Left and right controls/icons -->
    <a class="carousel-control-prev" href="#productCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </a>
    <a class="carousel-control-next" href="#productCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </a>
</div>
@endif
</div>
            

        <!-- Second Column: Product Details and Attributes -->
<!-- Product Details -->
        <div class="col-md-4 product-details">
           
            <div class="product-descrp">
    <h4>{{ $product->Name }}</h4>
    <table class="product-details-table">
        <tbody>
            <tr>
                <td><strong>Part No. (SKU)</strong></td>
                <td>{{ $product->SKU }}</td>
            </tr>
            <tr>
                <td><strong>Description</strong></td>
                <td>{{ $product->Description }}</td>
            </tr>
            <tr>
                <td><strong>Standard</strong></td>
                <td>{{ $product->Standard }}</td>
            </tr>
            <tr>
                <td><strong>Manufacturer</strong></td>
                <td>{{ $product->manufacturer->Name ?? 'No Manufacturer' }}</td>
            </tr>
        </tbody>
    </table>
</div>
                
                <div class="product-attributes-heading"><strong>Product Attributes</strong></div>
                <table class=" product-details-table">
        <tbody>
            <tr>
                <td><strong>Size</strong></td>
                <td>{{ $product->Size }}</td>
            </tr>
            <tr>
                <td><strong>Length</strong></td>
                <td>{{ $product->Length }}</td>
            </tr>
            <tr>
                <td><strong>Material</strong></td>
                <td>{{ $product->Material }}</td>
            </tr>
            <tr>
                <td><strong>Type</strong></td>
                <td>{{ $product->Type }}</td>
            </tr>
            <tr>
                <td><strong>Color</strong></td>
                <td>{{ $product->Color }}</td>
            </tr>
            <tr>
                <td><strong>Property Class</strong></td>
                <td>{{ $product->Property_Class }}</td>
            </tr>
        </tbody>
    </table>
            </ul>
        </div>
      
        <!-- Third Column: Pricing and Supply Chain -->
        <div class="col-md-3">
            <div class="price-container" style="margin-top: 30px;">
                <!-- <h4 style="color: #333; font-size: 20px; margin-bottom: 10px;">Price</h4> -->
                <p style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    <strong style="color: #0088cc; font-size: 18px;">Online Price:</strong>
                    <span style="font-size: 24px; font-weight: bold; color: #2c3e50;">₹{{ number_format($product->SalePrice, 2) }}</span>
                </p>
            </div>
            
            <div class="catalog-item">Special discount for vendors! Checkout to explore!</div>
            <div class="quantity mb-3" style="padding-top: 10px;">
                <label for="quantity"><strong>Quantity:</strong></label>
                <input type="number" id="quantity" name="quantity" min="1" value="1" class="form-control w-auto">
            </div>


            @if (auth()->check())
        <button class="btn btn-primary mb-3 btn-add-to-cart" data-product-id="{{ $product->ProductID }}" data-cart-add-url="{{ route('cart.add') }}"><i class="fas fa-shopping-cart"></i><small> Add to Cart</small></button>
        <!-- Bulk Order Button -->
        <button class="btn btn-secondary mb-3 btn-bulk-order" data-bs-toggle="modal"data-product-id="{{ $product->ProductID }}"
        data-user-name="{{ auth()->user()->name }}"
        data-user-email="{{ auth()->user()->email }}"
        data-user-phone="{{ auth()->user()->phone_number }}"
         data-bs-target="#bulkOrderModal"><small>Request Bulk Order</small></button>

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
        <a href="{{ route('login') }}?redirect_to={{ url()->current() }}" class="btn btn-primary mb-3 btn-add-to-cart"><i class="fas fa-shopping-cart"></i> Sign in to add to cart</a>
        <a href="{{ route('login') }}?redirect_to={{ url()->current() }}" class="btn btn-secondary mb-3">Sign in to request bulk order</a>
        @endif
    
            <ul class="list-unstyled">
<div class="product-attributes-heading"><strong>Supply Chain</strong></div>
<table class=" product-details-table">
        <tbody>
            <tr>
                <td><strong>Availability</strong></td>
                <td><span class="{{ $product->Quantity > 0 ? 'text-success' : 'text-danger' }}">{{ $product->Quantity > 0 ? 'In Stock' : 'Out of Stock' }}</span></td>
            </tr>
            <tr>
                <td><strong>Direct Ship</strong></td>
                <td>Shipping in 5-7 days</td>
            </tr>

         </tbody>
    </table>
                
</ul>
            
        </div>
    </div>
</div>
@endsection

