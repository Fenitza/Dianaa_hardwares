{{-- resources/views/cart/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Cart</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cartItems as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total:</th>
                <th>{{ number_format($total, 2) }}</th>
            </tr>
        </tfoot>
    </table>
    <div class="text-right">
        <button class="btn btn-primary">Proceed to Checkout</button>
    </div>
</div>
@endsection
