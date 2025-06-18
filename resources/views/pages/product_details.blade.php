@extends('layouts.app')
<title>{{$product->Description}}-Dianaa Fasteners</title>
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
            <input type="hidden" name="selected_color" id="selectedColor">
<input type="hidden" name="selected_price" id="selectedPrice">

@php
    $defaultVariant = $product->colorVariants->first();
    $discount = $product->discount ?? 0;
    $salePrice = $defaultVariant->sale_price ?? 0;
    $basePrice = $salePrice - ($salePrice * $discount / 100);
    $savings = $salePrice - $basePrice;
@endphp

<div class="form-group mb-3">
    <label for="colorSelect"><strong>Select Color:</strong></label>
    <select id="colorSelect" class="form-select">
        @foreach($product->colorVariants as $variant)
            <option 
                value="{{ $variant->sale_price }}" 
                data-color="{{ $variant->color }}" 
                data-saleprice="{{ $variant->sale_price }}">
                {{ $variant->color }}
            </option>
        @endforeach
    </select>
</div>

<div class="price-container p-3 rounded shadow-sm bg-light border" style="max-width: 320px;">
    @if ($discount > 0)
        <div class="mb-3">
            <span class="discount-badge">{{ $discount }}% OFF</span>
        </div>
    @endif

    <div class="mb-2 text-muted">
        <strong class="text-primary">Original Price:</strong>
        <span id="originalPrice">₹{{ number_format($salePrice, 2) }}</span>
    </div>

    <div class="mb-2 text-success">
        <strong>You Save:</strong>
        <span id="youSave">₹{{ number_format($savings, 2) }}</span>
    </div>

    <div class="mb-1 text-primary">
        Online Price:
        <span id="onlinePrice">₹{{ number_format($basePrice, 2) }}</span>
    </div>
</div>

<div class="quantity mb-3">
    <label for="quantity"><strong>Quantity:</strong></label>
    <input type="number" id="quantity" name="quantity" min="1" value="{{ $product->moq }}" class="form-control w-auto">
</div>

@if (auth()->check())
    <button class="btn btn-primary mb-3 btn-add-to-cart" 
        data-product-id="{{ $product->ProductID }}" 
        data-cart-add-url="{{ route('cart.add') }}">
        <i class="fas fa-shopping-cart"></i> Add to Cart
    </button>

    <button class="btn btn-secondary mb-3 btn-bulk-order" data-bs-toggle="modal" 
        data-product-id="{{ $product->ProductID }}"
        data-user-name="{{ auth()->user()->name }}"
        data-user-email="{{ auth()->user()->email }}"
        data-user-phone="{{ auth()->user()->phone_number }}"
        data-bs-target="#bulkOrderModal">
        Request Bulk Order
    </button>

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
                            <input type="number" class="form-control" id="bulkQuantity" name="quantity" min="1" value="{{ $product->moq }}">
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Additional Message</label>
                            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
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
    const selectedColorInput = document.getElementById('selectedColor');
    const selectedPriceInput = document.getElementById('selectedPrice');
    const discount = {{ $discount ?? 0 }};

    function updatePrices() {
        const selectedOption = colorSelect.options[colorSelect.selectedIndex];
        const salePrice = parseFloat(selectedOption.getAttribute('data-saleprice')) || 0;
        const color = selectedOption.getAttribute('data-color') || '';

        const basePrice = salePrice - (salePrice * discount / 100);
        const savings = salePrice - basePrice;

        document.getElementById('originalPrice').innerText = `₹${salePrice.toFixed(2)}`;
        document.getElementById('youSave').innerText = `₹${savings.toFixed(2)}`;
        document.getElementById('onlinePrice').innerText = `₹${basePrice.toFixed(2)}`;

        selectedColorInput.value = color;
        selectedPriceInput.value = basePrice.toFixed(2);
    }

    updatePrices();
    colorSelect.addEventListener('change', updatePrices);

    document.querySelector('.btn-add-to-cart').addEventListener('click', function () {
        const productId = this.getAttribute('data-product-id');
        const cartAddUrl = this.getAttribute('data-cart-add-url');
        const quantity = document.getElementById('quantity').value;
        const selectedColor = selectedColorInput.value;
        const selectedPrice = selectedPriceInput.value;

        fetch(cartAddUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity,
                selected_color: selectedColor,
                selected_price: selectedPrice
            })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message || 'Added to cart');
        })
        .catch(error => {
            console.error('Add to cart error:', error);
            alert('Something went wrong');
        });
    });
});    //zoom
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
