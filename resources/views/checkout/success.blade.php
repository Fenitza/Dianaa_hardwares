{{-- resources/views/checkout/success.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Order Confirmation
        </div>
        <div class="card-body">
            @php
                $order = session('order') ?? $order;  // Fallback to direct variable if not in session
            @endphp
            <h5 class="card-title">Thank You for Your Order, {{ $order->user->name }}!</h5>
            <p class="card-text">Your order has been placed successfully and is now being processed.</p>

            <div class="row">
                <div class="col-md-6">
                    <h6>Order Summary</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6>Billing Details</h6>
                    @php
                        $billing_details = json_decode($order->billing_details);
                    @endphp
                    <ul class="list-unstyled">
                        <li><strong>Name:</strong> {{ $billing_details->name }}</li>
                        <li><strong>Email:</strong> {{ $billing_details->email }}</li>
                        <li><strong>Address:</strong> {{ $billing_details->address }}</li>
                        <li><strong>City:</strong> {{ $billing_details->city }}</li>
                        <li><strong>State:</strong> {{ $billing_details->state }}</li>
                        <li><strong>Postal Code:</strong> {{ $billing_details->postal_code }}</li>
                        <li><strong>Country:</strong> {{ $billing_details->country }}</li>
                    </ul>

                    <h6>Payment Status: <span class="badge bg-success">{{ $order->payment_status }}</span></h6>
                </div>
            </div>

            <a href="{{ url('/') }}" class="btn btn-primary mt-4">Return Home</a>
        </div>
    </div>
</div>
@endsection
