@extends('layouts.app')

@section('content')
<!-- Spacer Block -->
<div class="custom-spacer"></div>

<div class="product-detail-container">
    <div class="row product-detail-page">
        <!-- Product Image Carousel -->
        <div class="col-md-4" style="margin-top: 50px;">
            @if(!empty($product->image_paths) && is_array($product->image_paths))
            <div id="productCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($product->image_paths as $key => $imagePath)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $imagePath) }}" class="d-block w-100" alt="Product Image">
                    </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#productCarousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#productCarousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>

            <div class="d-flex flex-wrap gap-2 justify-content-center">
                @foreach($product->image_paths as $key => $imagePath)
                <img src="{{ asset('storage/' . $imagePath) }}"
                     class="img-thumbnail product-thumb"
                     data-bs-toggle="modal"
                     data-bs-target="#zoomModal"
                     data-zoom-src="{{ asset('storage/' . $imagePath) }}"
                     style="width: 80px; height: 80px; object-fit: cover; cursor: zoom-in; border-radius: 4px;">
                @endforeach
            </div>
            @endif
        </div>

        <!-- Zoom Modal -->
        <div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <img id="zoomedImage" src="" class="w-100" style="object-fit: contain;" alt="Zoomed Image">
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-4 product-details">
            <div class="product-descrp">
                <h4>{{ $product->Name }}</h4>
                <table class="product-details-table">
                    <tbody>
                        <tr><td><strong>Part No. (SKU)</strong></td><td>{{ $product->SKU }}</td></tr>
                        <tr><td><strong>Description</strong></td><td>{{ $product->Description }}</td></tr>
                        <tr><td><strong>Standard</strong></td><td>{{ $product->standardISO }}</td></tr>
                        <tr><td><strong>Manufacturer</strong></td><td>{{ $product->manufacturer->Name ?? 'No Manufacturer' }}</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="product-attributes-heading"><strong>Product Description</strong></div>
            <table class="product-details-table">
                <tbody>
                    <tr><td><strong>Thread Size</strong></td><td>{{ $product->Size }}</td></tr>
                    <tr><td><strong>Length</strong></td><td>{{ $product->Length }}</td></tr>
                    <tr><td><strong>Grade</strong></td><td>{{ $product->grade }}</td></tr>
                    <tr><td><strong>Pitch</strong></td><td>{{ $product->pitch }}</td></tr>
                    <tr><td><strong>Weight</strong></td><td>{{ $product->weight }}</td></tr>
                </tbody>
            </table>

            <div class="product-attributes-heading"><strong>Product Attributes</strong></div>
            <table class="product-details-table">
                <tbody>
                    <tr><td><strong>Full / Half Thread</strong></td><td>{{ $product->threadType }}</td></tr>
                    <tr><td><strong>Metric or Inches</strong></td><td>{{ $product->metric }}</td></tr>
                    <tr><td><strong>UNC / UNF / BSF / BSW</strong></td><td>{{ $product->standardType }}</td></tr>
                    <tr><td><strong>Cone/Cup/Flat Points</strong></td><td>{{ $product->point }}</td></tr>
                    <tr><td><strong>Pitch Type</strong></td><td>{{ $product->pitchType }}</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Pricing and Color Selection -->
        <div class="col-md-3">
            <div class="product-attributes-heading"><strong>Supply Chain</strong></div>
            <table class="product-details-table">
                <tbody>
                    <tr><td><strong>Availability</strong></td><td><span class="{{ $product->Quantity > 0 ? 'text-success' : 'text-danger' }}">{{ $product->Quantity > 0 ? 'In Stock' : 'Out of Stock' }}</span></td></tr>
                    <tr><td><strong>Direct Ship</strong></td><td>Shipping in 5-7 days</td></tr>
                </tbody>
            </table>

            @php
    $defaultVariant = $product->colorVariants->first();
    $discount = $product->discount ?? 0;
    $salePrice = $defaultVariant->sale_price ?? 0;
    $basePrice = $salePrice - ($salePrice * $discount / 100);
    $savings = $salePrice - $basePrice;
@endphp

<div class="form-group mb-3" style="font-size: 0.9rem;">
    <label for="colorSelect" class="form-label" style="font-size: 0.85rem;"><strong>Select Color:</strong></label>
    <select id="colorSelect" class="form-select" style="font-size: 0.85rem; padding: 4px 8px;">
        @foreach($product->colorVariants as $variant)
            <option value="{{ $variant->sale_price }}">{{ $variant->color }}</option>
        @endforeach
    </select>
</div>


<div class="price-container p-3 rounded shadow-sm bg-light border" style="max-width: 320px; font-family: 'Segoe UI', sans-serif;">

    @if ($discount > 0)
    <div class="mb-3">
        <span class="discount-badge">
            {{ $discount }}% OFF
        </span>
    </div>
    @endif

    <div class="mb-2 text-muted price-label">
        <strong class="text-primary">Original Price:</strong>
        <span id="originalPrice" class="price-strike">
            ₹{{ number_format($salePrice, 2) }}
        </span>
    </div>

    <div class="mb-2 text-success price-label">
        <strong>You Save:</strong>
       <span id="youSave"> ₹{{ number_format($savings, 2) }}</span>
    </div>

    <div class="mb-1 text-primary price-label">
        Online Price:
        <span id="onlinePrice" class="online-price">
            ₹{{ number_format($basePrice, 2) }}
        </span>
    </div>
</div>


            <div class="quantity mb-3" style="padding-top: 10px;">
                <label for="quantity"><strong>Quantity:</strong></label>
                <input type="number" id="quantity" name="quantity" min="1" value="{{$product->moq}}" class="form-control w-auto">
            </div>

            @if (auth()->check())
                <button class="btn btn-primary mb-3 btn-add-to-cart" data-product-id="{{ $product->ProductID }}" data-cart-add-url="{{ route('cart.add') }}"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                <button class="btn btn-secondary mb-3 btn-bulk-order" data-bs-toggle="modal" data-product-id="{{ $product->ProductID }}"
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                        <div class="modal-body">
                            <form id="bulkOrderForm" data-product-id="{{ $product->ProductID }}"
                                data-user-name="{{ auth()->user()->name }}"
                                data-user-email="{{ auth()->user()->email }}"
                                data-user-phone="{{ auth()->user()->phone_number }}">
                                <div class="mb-3">
                                    <label for="bulkQuantity" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="bulkQuantity" name="quantity" min="1" value="{{$product->moq}}">
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
                <a href="{{ route('login') }}?redirect_to={{ url()->current() }}" class="btn btn-primary mb-3">Sign in to add to cart</a>
                <a href="{{ route('login') }}?redirect_to={{ url()->current() }}" class="btn btn-secondary mb-3">Sign in to request bulk order</a>
            @endif
        </div>
    </div>
</div>

<style>
.discount-badge {
    background-color: #dc3545;
    color: #fff !important;
    font-size: 0.75rem !important;
    padding: 4px 10px !important;
    border-radius: 20px !important;
    font-weight: 600 !important;
    display: inline-block !important;
    letter-spacing: 0.5px !important;
}

.price-label {
    font-size: 0.9rem !important;
    margin-bottom: 4px !important;
    color: #555 !important;
}

.price-strike {
    text-decoration: line-through !important;
    font-weight: 600 !important;
    color: #888 !important;
}

.price-savings {
    font-weight: 600 !important;
    color: #2E7D32 !important; /* Green */
}

.online-price {
    font-size: 1.5rem !important;
    font-weight: 700 !important;
    color: #0D47A1 !important; /* Deep Blue */
}

#zoomedImage {
    max-height: 80vh;
    width: 100%;
    object-fit: contain;
    background-color: #f9f9f9;
    padding: 10px;
}
/* Modal dialog size and spacing */
.modal-dialog {
    max-width: 450px;
    margin: 2rem auto;
}

/* Modal card-style layout */
.modal-content {
    border-radius: 16px;
    border: none;
    padding: 24px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

/* Modal header */
.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    white-space: nowrap;
    overflow: hidden;
    /* text-overflow: ellipsis; */
    max-width: 90%;
    font-size: 1.4rem;
    font-weight: 600;
}

.modal-header .close {
    font-size: 1.5rem;
    color: #999;
    background: none;
    border: none;
    padding: 0;
}

.modal-header .close:hover {
    color: #000;
}
.btn-close {
  width: 1rem !important;
  height: 1rem !important;
  font-size: 0.8rem !important;
  background-size: 1rem !important;
} 

/* Input field style */
.form-label {
    font-weight: 500;
    margin-bottom: 8px;
    color: #333;
}

.form-control {
    border-radius: 10px;
    border: 1px solid #ddd;
    padding: 12px;
    font-size: 1rem;
    background-color: #f9f9f9;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    background-color: #fff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.1);
}

/* Submit button style */
.btn-primary {
    width: 100%;
    border-radius: 8px;
    padding: 12px 0;
    font-weight: 600;
    font-size: 1rem;
    background: linear-gradient(to right, #007bff, #0056b3);
    border: none;
    transition: background 0.3s;
}

.btn-primary:hover {
    background: linear-gradient(to right, #0056b3, #003f7f);
    box-shadow: 0 4px 14px rgba(0, 91, 187, 0.3);
}

</style>



@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const colorSelect = document.getElementById('colorSelect');
    const originalPrice = document.getElementById('originalPrice');
    const youSave = document.getElementById('youSave');
    const onlinePrice = document.getElementById('onlinePrice');
    const discount = {{ $product->discount ?? 0 }};

    if (colorSelect && originalPrice && youSave && onlinePrice) {
        colorSelect.addEventListener('change', function () {
            const sale = parseFloat(this.value);
            const base = sale - (sale * discount / 100);
            const save = sale - base;

            originalPrice.textContent = '₹' + sale.toFixed(2);
            youSave.textContent = save.toFixed(2);
            onlinePrice.textContent = '₹' + base.toFixed(2);
        });
    }
});
document.addEventListener('DOMContentLoaded', function () {
    const zoomModal = document.getElementById('zoomModal');
    const zoomedImage = document.getElementById('zoomedImage');

    zoomModal.addEventListener('show.bs.modal', function (event) {
        const triggerImage = event.relatedTarget;
        const src = triggerImage.getAttribute('data-zoom-src');
        zoomedImage.setAttribute('src', src);
    });
});

</script>
@endpush

@endsection
