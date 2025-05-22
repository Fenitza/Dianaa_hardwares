@extends('layouts.app')

@section('content')
<!-- Spacer Block -->
<div class="custom-spacer"></div>

<div class="product-detail-container">
    <div class="row product-detail-page">
        <!-- First Column: Product Image -->
        <!-- <div class="col-md-4" style="margin-top: 50px; ">
        <img src="{{ asset('storage/' . $product->product_image) }}" alt="Product_Image" class="product-img" 
            style="width: 100%; height: auto; position:contain;">
        </div> -->

        <!-- Product Image Carousel -->
        <div class="col-md-4" style="margin-top: 50px;">
            @if(!empty($product->image_paths) && is_array($product->image_paths))
            <div id="productCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                <!-- Carousel Inner -->
                <div class="carousel-inner">
                    @foreach($product->image_paths as $key => $imagePath)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $imagePath) }}" class="d-block w-100" alt="Product Image">
                    </div>
                    @endforeach
                </div>

                <!-- Controls -->
                <a class="carousel-control-prev" href="#productCarousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#productCarousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>

            <!-- Thumbnails -->
            <div class="d-flex flex-wrap gap-2 justify-content-center">
                @foreach($product->image_paths as $key => $imagePath)
                <img
                    src="{{ asset('storage/' . $imagePath) }}"
                    class="img-thumbnail product-thumb"
                    data-bs-target="#productCarousel"
                    data-bs-slide-to="{{ $key }}"
                    style="width: 80px; height: 80px; object-fit: cover; cursor: pointer; border-radius: 4px;">
                @endforeach
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
                            <td>{{ $product->standardISO }}</td>
                        </tr>
                        <tr>
                            <td><strong>Manufacturer</strong></td>
                            <td>{{ $product->manufacturer->Name ?? 'No Manufacturer' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="product-attributes-heading"><strong>Product Description</strong></div>
            <table class=" product-details-table">
                <tbody>
                    <tr>
                        <td><strong>Thread Size</strong></td>
                        <td>{{ $product->Size }}</td>
                    </tr>
                    <tr>
                        <td><strong>Length</strong></td>
                        <td>{{ $product->Length }}</td>
                    </tr>
                    <tr>
                        <td><strong>Grade</strong></td>
                        <td>{{ $product->grade }}</td>
                    </tr>
                    <tr>
                        <td><strong>Pitch</strong></td>
                        <td>{{ $product->pitch }}</td>
                    </tr>
                    <tr>
                        <td><strong>Color</strong></td>
                        <td>{{ $product->Color }}</td>
                    </tr>
                    <tr>
                        <td><strong>Weight</strong></td>
                        <td>{{ $product->weight }}</td>
                    </tr>
                </tbody>
            </table>
            </ul>
            <div class="product-attributes-heading"><strong>Product Attributes</strong></div>
            <table class=" product-details-table">
                <tbody>

                    <tr>
                        <td><strong>Full / Half Thread</strong></td>
                        <td>{{ $product->threadType }}</td>
                    </tr>
                    <tr>
                        <td><strong>Metric or Inches</strong></td>
                        <td>{{ $product->metric }}</td>
                    </tr>
                    <tr>
                        <td><strong>UNC / UNF / BSF / BSW</strong></td>
                        <td>{{ $product->standardType }}</td>
                    </tr>
                    <tr>
                        <td><strong>Cone/Cup/Flat Points</strong></td>
                        <td>{{ $product->point }}</td>
                    </tr>
                    <tr>
                        <td><strong>Pitch Type</strong></td>
                        <td>{{ $product->pitchType }}</td>
                    </tr>

                </tbody>
            </table>


        </div>

        <!-- Third Column: Pricing and Supply Chain -->
        <div class="col-md-3">
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
            @php
            $salePrice = $product->SalePrice;
            $discount = $product->discount;

            // Calculate sale price from base price and discount
            $basePrice = $salePrice - ($salePrice * $discount / 100);
            $savings = $salePrice - $basePrice;
            @endphp

            <div class="price-container p-3 rounded shadow-sm bg-light border" style="max-width: 320px; font-family: 'Segoe UI', sans-serif;">

                @if ($discount > 0)
                <div class="mb-3">
                    <span class="badge" style="
                background-color: #dc3545;
                color: #fff;
                font-size: 0.85rem;
                padding: 6px 12px;
                border-radius: 6px;
                font-weight: 600;
            ">
                        {{ $discount }}% OFF
                    </span>
                </div>
                @endif

                <div class="mb-2" style="color: #6c757d; font-size: 0.95rem;">
                    <strong style="color: #007bff;">Original Price:</strong>
                    <span style="text-decoration: line-through; font-weight: 600;">
                        ₹{{ number_format($salePrice, 2) }}
                    </span>
                </div>

                <div class="mb-2" style="color: #28a745; font-size: 0.95rem;">
                    <strong>You Save:</strong>
                    ₹{{ number_format($savings, 2) }}
                </div>

                <div class="mb-1" style="color: #007bff; font-size: 1rem; font-weight: 600;">
                    Online Price:

                    <span style="font-size: 1.7rem; font-weight: bold; color: #212529;">
                        ₹{{ number_format($basePrice, 2) }}
                    </span>
                </div>
            </div>



            <div class="catalog-item">Special discount for vendors! Checkout to explore!</div>
            <div class="quantity mb-3" style="padding-top: 10px;">
                <label for="quantity"><strong>Quantity:</strong></label>
                <input type="number" id="quantity" name="quantity" min="1" value="{{$product->moq}}" class="form-control w-auto">
            </div>


            @if (auth()->check())
            <button class="btn btn-primary mb-3 btn-add-to-cart" data-product-id="{{ $product->ProductID }}" data-cart-add-url="{{ route('cart.add') }}"><i class="fas fa-shopping-cart"></i><small> Add to Cart</small></button>
            <!-- Bulk Order Button -->
            <button class="btn btn-secondary mb-3 btn-bulk-order" data-bs-toggle="modal" data-product-id="{{ $product->ProductID }}"
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



        </div>
    </div>
</div>
<style>
    .price-container:hover {
        transform: translateY(-2px);
        transition: 0.3s ease;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection