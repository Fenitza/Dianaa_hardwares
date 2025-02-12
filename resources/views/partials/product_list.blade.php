<!-- Spacer Block -->
<div class="custom-spacer" style="height: 20px;"></div>

<!-- Product List -->
<div class="product-list">
    @foreach ($products as $product)
    <div class="product" onclick="window.location.href='{{ route('product.details', ['ProductID' => $product->ProductID]) }}'">
    <div class="row mb-3 align-items-center">
        <div class="col-md-1">
        <img src="{{ asset('images/Products/product_1.jpg') }}" class="card-img" alt="{{ $product->Name }}">
        </div>
        <div class="col-md-4 product-list-info">
            <strong>Dianaa Fasteners Part No. (SKU):</strong> {{ $product->SKU }}<br>
            <strong>Description:</strong> {{ $product->Description }}<br>
            <strong>Manufacturer:</strong> {{ $product->Manufacturer }}
        </div>
        <div class="col-md-2">
            <strong>Online Price:</strong><br>
            ${{ number_format($product->SalePrice, 2) }}
        </div>
        <div class="col-md-2">
            <span class="{{ $product->Quantity > 0 ? 'text-success' : 'text-danger' }}">
                {{ $product->Quantity > 0 ? 'In Stock' : 'Out of Stock' }}
            </span>
        </div>
        <div class="col-md-2 d-flex align-items-center">
            <input type="number" min="1" value="1" class="form-control" style="width: 70px; display: inline-block; margin-right: 10px;">
            <button class="btn btn-primary">
                <i class="fas fa-shopping-cart"></i>
            </button>
        </div>
    </div>
</div>
    @endforeach
</div>
