<!-- Spacer Block -->
<div class="custom-spacer" style="height: 30px;"></div>

<!-- Product Grid -->
<div class="product-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
    @foreach ($products as $product)
    <div class="product">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('storage/' . $product->product_image) }}" alt="Product Image" class="card-img-top" 
                     onclick="window.location.href='{{ route('product.details', ['ProductID' => $product->ProductID]) }}'" style="cursor: pointer;">
            </div>
            <div class="col-md-8 d-flex flex-column product-info">
                <p><b>Dianaa Fasteners Part No.(SKU): </b><span style="color: blue;">{{ $product->SKU }}</span></p>
                <h4>{{ $product->Name }}</h4>
                <p>{{ $product->Description }}</p>
                <p><b>Manufacturer: </b>{{ $product->manufacturer->Name }}</p>
                <p><b>Online Price:</b> ₹{{ number_format($product->SalePrice, 2) }}</p>
            </div>
        </div>
        <div class="product-actions" style="margin-top: 10px;">
            <span class="{{ $product->Quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                {{ $product->Quantity > 0 ? 'In Stock' : 'Out of Stock' }}
            </span>
            <div class="actions-right">
                <input type="number" value="1" min="1" name="quantity{{ $product->id }}" class="quantity-input">
                <button class="cart-btn">
                    <i class="fas fa-shopping-cart"></i>
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Spacer Block -->
<div class="custom-spacer" style="height: 50px;"></div>

<!-- <script>
    document.querySelectorAll('.product').forEach(item => {
    item.addEventListener('click', function() {
        window.location.href = "{{ url('subcategories/products') }}/" + this.getAttribute('data-product-id');
    });
});
</script> -->
