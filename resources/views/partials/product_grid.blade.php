

<div class="col-md-12">
            
    <div class="product-grid" id="product-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
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
                <p><b>Manufacturer: </b>{{ $product->Manufacturer }}</p>
                <p><b>Online Price:</b> ₹{{ number_format($product->SalePrice, 2) }}</p>
            </div>
        </div>
        <div class="product-actions" style="margin-top: 10px;">
            <span class="{{ $product->Quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                {{ $product->Quantity > 0 ? 'In Stock' : 'Out of Stock' }}
            </span>
            <div class="actions-right">
                <input type="number" value="1" min="1" name="quantity{{ $product->ProductID }}" id="quantity" class="quantity-input">
                @if (auth()->check())
                    <button class="btn btn-primary mb-3 btn-add-to-cart" data-product-id="{{ $product->ProductID }}" data-cart-add-url="{{ route('cart.add') }}"><i class="fas fa-shopping-cart"></i></button>
            
                
                @else
        <!-- Link to the login page if the user is not authenticated -->
         <a href="{{ route('login') }}?redirect_to={{ url()->current() }}" class="btn btn-primary mb-3 btn-add-to-cart"><i class="fas fa-shopping-cart"></i></a>

   
    @endif       
    </div>
        </div>
    </div>
    @endforeach
</div>
</div>



<script>
    document.getElementById('perPage').addEventListener('change', function() {
    let perPage = this.value;
    let currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('perPage', perPage);
    window.location.href = currentUrl.href;
});
</script>
