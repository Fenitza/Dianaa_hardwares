@extends('layouts.app')

@section('content')
<div class="container" id="cart-container">
    <div class="cart-header" id="cart-header">
        <h2>Your Shopping Cart</h2>
    </div>
    <?php if (Auth::user() && Auth::user()->role === 'vendor'): ?>
        <div class="catalog-item">Special discount for vendors! Just for you!</div>
    <?php endif; ?>

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
                <td>
                    @if ($item->product)
                        <img src="{{ asset('storage/' . $item->product->product_image) }}" alt="{{ $item->product->Name }}" style="width:50px; height:50px;">
                    @else
                        <p>No Image</p>
                    @endif
                </td>
                <td>
                    @if ($item->product)
                        <a href="{{ route('product.details', ['ProductID' => $item->product->ProductID]) }}">{{ $item->product->Name }}</a><br>
                        <small>Manufacturer: {{ $item->product->Manufacturer ?? 'Not available' }}</small><br>
                        <small>SKU: {{ $item->product->SKU ?? 'N/A' }}</small><br>
                        <small>Shipping: Leaves warehouse in 3-7 days</small>
                    @else
                        <p>Product not found</p>
                    @endif
                </td>
                <td>
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
                <td>₹{{ number_format($total, 2) }}</td>
            </tr>
        </tfoot>
    </table>
    <div class="cart-actions" id="cart-actions">
        <button class="btn btn-secondary" id="empty-cart" data-empty-cart-url="{{ route('cart.empty') }}">
            Empty Cart
        </button>
        <button class="btn btn-success" id="checkout">Check Out</button>
    </div>
</div>
@endsection
