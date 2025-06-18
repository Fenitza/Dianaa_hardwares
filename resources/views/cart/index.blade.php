@extends('layouts.app')
<title>Cart - Dianaa Fasteners</title>

@section('content')
<div class="container" id="cart-container">
    <div class="cart-header" id="cart-header">
        <h2>Your Shopping Cart</h2>
    </div>

    @if (Auth::user() && Auth::user()->role === 'vendor')
        <div class="alert alert-info">Special discount for vendors! Just for you!</div>
    @endif

    <table class="table cart-table" id="cart-table">
        <thead class="thead-light">
            <tr>
                <th>Image</th>
                <th>Description</th>
                <th>Action</th>
                <th>Qty</th>
                <th>Selected Color</th>
                <th>Unit Price</th>
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
                        <a href="{{ route('product.details', ['ProductID' => $item->product->ProductID]) }}">
                            {{ $item->product->Description }}
                        </a><br>
                        <small>Manufacturer: {{ $item->product->manufacturer->Name ?? 'Not available' }}</small><br>
                        <small>SKU: {{ $item->product->SKU ?? 'N/A' }}</small><br>
                        <small>Shipping: Leaves warehouse in 3–7 days</small>
                    @else
                        <p>Product not found</p>
                    @endif
                </td>
                <td>
                    <input type="number" id="quantity" value="{{ $item->quantity }}" min="1" style="width: 50px;" onchange="updateQuantity({{ $item->id }}, this.value)">
                    <button class="btn btn-danger btn-sm mt-1" onclick="removeItem({{ $item->id }})">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->selected_color ?? '-' }}</td>
                <td>₹{{ number_format($item->selected_price, 2) }}</td>
                <td>₹{{ number_format($item->selected_price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right"><strong>Total:</strong></td>
                <td><strong>₹{{ number_format($total, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="cart-actions mt-4 d-flex justify-content-between">
        <button class="btn btn-secondary" id="empty-cart" data-empty-cart-url="{{ route('cart.empty') }}">
            Empty Cart
        </button>
        <button class="btn btn-success" id="checkout">Check Out</button>
    </div>
</div>
@endsection
