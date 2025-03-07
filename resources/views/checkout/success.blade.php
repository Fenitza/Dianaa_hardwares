{{-- resources/views/checkout/success.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card border-success">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center" style="width: 100%;">
            <span>Order Confirmation</span>
            <span></span> <!-- Empty span for right alignment -->
        </div>
        <div class="card-body text-dark text-center">
            @if (session('order') && session('order')->items && session('order')->products)
                @php
                    $order = session('order');
                    $billing_details = json_decode($order->billing_details);
                @endphp
                <h5 class="card-title">Thank You, {{ $billing_details->name }}!</h5>
                <p>Your order has been successfully placed and is now being processed.</p>

                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h6 class="text-secondary">Order Summary</h6>
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($order->items->isNotEmpty())
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ optional($item->product)->Name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="3">No items found in this order.</td></tr>
                        @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-secondary">Billing Information</h6>
                        <div class="info-box">
                            <p>{{ $billing_details->name }}</p>
                            <p>{{ $billing_details->email }}</p>
                            <p>{{ $billing_details->address }}</p>
                            <p>{{ $billing_details->city }}, {{ $billing_details->state }}, {{ $billing_details->postal_code }}</p>
                            <p>{{ $billing_details->country }}</p>
                        </div>
                    </div>
                </div>

                <a href="{{ url('/') }}" class="btn btn-success mt-4">Return Home</a>
            @else
                <p class="text-warning">Order information is not available.</p>
            @endif
        </div>
    </div>
</div>

<style>
    .info-box p {
        margin-bottom: 0.5rem; /* Space between lines */
        line-height: 1.5; /* Line height for readability */
        color: #333; /* Dark grey text for better readability */
    }

    .card-header {
        font-size: 1.25rem; /* Slightly larger text in header for emphasis */
    }
{{-- resources/views/checkout/success.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card border-0 shadow">
        <div class="card-header bg-success text-white text-center">
            Order Confirmation
        </div>
        <div class="card-body text-dark">
            @if (session('order'))
                @php
                    $order = session('order');
                    $billing_details = json_decode($order->billing_details);
                @endphp
                <div class="text-center mb-4">
                    <h5 class="card-title">Thank You, {{ $billing_details->name }}!</h5>
                    <p>Your order has been successfully placed and is now being processed.</p>
                </div>

                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <h6 class="text-secondary text-center">Order Summary</h6>
                        <table class="table table-bordered">
                            <thead class="table-light">
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
                </div>

                <div class="text-center mt-4 mb-4">
                    <h6 class="text-secondary">Billing Information</h6>
                    <p>{{ $billing_details->name }}<br>
                        {{ $billing_details->email }}<br>
                        {{ $billing_details->address }}<br>
                        {{ $billing_details->city }}, {{ $billing_details->state }}, {{ $billing_details->postal_code }}<br>
                        {{ $billing_details->country }}
                    </p>
                </div>

                <div class="text-center">
                    <a href="{{ url('/') }}" class="btn btn-success">Return Home</a>
                </div>
            @else
                <p class="text-warning text-center">Order information is not available.</p>
            @endif
        </div>
    </div>
</div>
@endsection

<style>
    .card-header {
        font-size: 1.5rem;
    }
    .card-body {
        font-size: 1.1rem;
        background: #f8f9fa;
    }
    .table {
        margin-bottom: 0;
    }
</style>

    .card-body {
        padding: 2rem; /* More padding for better spacing */
    }
</style>
@endsection
