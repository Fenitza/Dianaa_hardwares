@extends('layouts.app')

@section('content')
<div class="container" id="cart-container">
    <div class="cart-header" id="cart-header">
        <h2>Your Shopping Cart</h2>
    </div>
    <table class="cart-table" id="cart-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Description</th>
                <th>Action</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cartItems as $item)
            <tr>
            <td><img src="{{ asset('storage/' . $item->attributes->product_image) }}" alt="{{ $item->name }}" style="width:50px; height:50px;"></td>
                <td>
                <a href="{{ route('product.details', ['ProductID' => $item->id]) }}">{{ $item->name }}</a><br>
                <small>Manufacturer: {{ $item->attributes['manufacturer'] ?? 'Not available' }}</small><br>
                <small>SKU: {{ $item->attributes['sku'] ?? 'N/A' }}</small><br>
                    <small>Shipping: Leaves warehouse in 3-7 days</small>
                </td>
                <td>
                    <!-- Action column now includes quantity input and a remove button -->
                    <input type="number" value="{{ $item->quantity }}" min="1" style="width: 50px; display: inline-block;" onchange="updateQuantity({{ $item->id }}, this.value)">
                    <button class="btn btn-danger btn-sm" onclick="removeItem({{ $item->id }})" style="margin-left: 10px;">
                        <i class="fa fa-trash"></i> <!-- Icon for removal -->
                    </button>
                </td>
                <td>{{ $item->quantity }}</td>
                <td>₹{{ number_format($item->price, 2) }}</td>
                <td>₹{{ number_format($item->quantity * $item->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right">Total:</td>
                <td>${{ number_format($total, 2) }}</td>
            </tr>
        </tfoot>
    </table>
    <div class="cart-actions" id="cart-actions">
        <button class="btn btn-primary" id="update-cart">Update Cart</button>
        <button class="btn btn-secondary" id="empty-cart">Empty Cart</button>
        <button class="btn btn-success" id="checkout">Check Out</button>
    </div>
</div>
@endsection

<script>
function updateQuantity(itemId, newQuantity) {
    // Implement AJAX to handle quantity update
    console.log('Updating item ' + itemId + ' to quantity ' + newQuantity);
    // Assuming you have a route setup for this, you'd make an AJAX request here
}

function removeItem(itemId) {
    // Implement AJAX to handle item removal
    console.log('Removing item ' + itemId);
    // Again, assuming you have a route setup for this, you'd make an AJAX request here
}
</script>
