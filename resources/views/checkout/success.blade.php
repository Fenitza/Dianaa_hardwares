{{-- resources/views/checkout/success.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <i class="fa fa-check-circle"></i> Thank you for your order!
        </div>
        <div class="card-body bg-light">
            <div class="text-center mb-3">
                <p>Your order has been successfully placed and is now being processed.</p>
                @if (session('order'))
                    @php
                        $order = session('order');
                        $billing_details = json_decode($order->billing_details);
                    @endphp
                    <p><strong>Order ID: {{ $order->order_id ?? 'N/A' }} - Success</strong></p>
                    <p><strong>Order Date: {{ $order->created_at->format('d M Y') }}</strong></p>
                @endif
            </div>

            <!-- Layout for address and summary -->
            <div class="row">
                <!-- Shipping and Billing Address -->
                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded bg-white">
                        <h6><i class="fa fa-truck"></i> Shipping Address</h6>
                        <p>{{ $billing_details->name }}<br>{{ $billing_details->address }}<br>{{ $billing_details->city }}, {{ $billing_details->state }} {{ $billing_details->postal_code }}<br>{{ $billing_details->country }}<br>Ph: {{ $billing_details->phone }}</p>
                    </div>
                    <div class="p-3 border rounded bg-white">
                        <h6><i class="fa fa-home"></i> Billing Address</h6>
                        <p>{{ $billing_details->name }}<br>{{ $billing_details->address }}<br>{{ $billing_details->city }}, {{ $billing_details->state }} {{ $billing_details->postal_code }}<br>{{ $billing_details->country }}<br>Ph: {{ $billing_details->phone }}</p>
                    </div>
                </div>

                <!-- Payment Method and Order Summary -->
                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded bg-white">
                        <h6><i class="fa fa-credit-card"></i> Payment Method</h6>
                        <p>Pay On Delivery</p>
                    </div>
                    <div class="p-3 border rounded bg-white">
                        <h6><i class="fa fa-list-alt"></i> Order Summary</h6>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->Name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>₹ {{ number_format($item->price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Subtotal</td>
                                    <td colspan="2" class="text-right">₹ {{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Shipping & Handling</td>
                                    <td colspan="2" class="text-right">₹ {{ number_format($order->shipping_cost, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Tax</td>
                                    <td colspan="2" class="text-right">₹ {{ number_format($order->tax, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Grand Total</strong></td>
                                    <td colspan="2" class="text-right"><strong>₹ {{ number_format($order->total_amount, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <button class="btn btn-primary btn-block"><i class="fa fa-print"></i> Print Order</button>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-secondary btn-block"><i class="fa fa-shopping-cart"></i> Continue Shopping</button>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-success btn-block"><i class="fa fa-redo"></i> Re-Order</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.card-header {
    font-size: 1.5rem;
    background-color: #007bff;
    color: white;
}
.card-body {
    background: #f8f9fa;
    font-size: 0.9rem;
}
.border {
    border-color: #dee2e6;
}
.rounded {
    border-radius: 0.25rem;
}
.table th, .table td {
    border-top: none;
}
.table thead th {
    border-bottom: 2px solid #dee2e6;
}
.table tfoot td {
    font-weight: bold;
}
.btn {
    padding: 0.75rem 1.25rem;
    width: 100%;
}
</style>
