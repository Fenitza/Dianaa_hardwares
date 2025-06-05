@extends('layouts.user')

@section('content')
<div class="container my-4">
    <h3 class="mb-4">Order Details</h3>

    <div class="card p-3 mb-3">
        <h5>Order Details</h5>
        <p><strong>Order ID:</strong> {{ $order->order_id }}</p>
        <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}</p>
    </div>

    <div class="card p-3 mb-3">
        <h5>Payment Info</h5>
        <p><strong>Status:</strong> {{ ucfirst($order->payment_status) }}</p>
        <p><strong>Total Amount:</strong> ₹{{ number_format($order->total_amount, 2) }}</p>
        <p><strong>Transaction ID:</strong> {{ $order->transaction_id ?? 'N/A' }}</p>
        <p><strong>Tracking ID:</strong> {{ $order->tracking_id ?? 'Not updated' }}</p>
    </div>

    <div class="card p-3 mb-3">
        <h5>Shipping Address</h5>
        @php $billing = json_decode($order->billing_details); @endphp
        <p>
            {{ $billing->name ?? '-' }}<br>
            {{ $billing->address ?? '' }}<br>
            {{ $billing->city ?? '' }}, {{ $billing->state ?? '' }} {{ $billing->postal_code ?? '' }}<br>
            {{ $billing->country ?? '' }}<br>
            Phone: {{ $billing->phone ?? '-' }}
        </p>
    </div>

    <div class="card p-3 mb-3">
        <h5>Items Ordered</h5>
        <table class="table table-bordered table-sm">
            <thead class="table-light">
                <tr>
                    <th>Product</th>
                    <th>Manufacturer</th>
                    <th>Qty</th>
                    <th>Unit Price (₹)</th>
                    <th>Total (₹)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->Description ?? 'N/A' }}</td>
                    <td>{{ $item->product->manufacturer->Name ?? 'N/A' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₹{{ number_format($item->price, 2) }}</td>
                    <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card p-3 mb-3">
        <h5>Payment Info</h5>
        <p><strong>Status:</strong> {{ ucfirst($order->payment_status) }}</p>
        <p><strong>Total Amount:</strong> ₹{{ number_format($order->total_amount, 2) }}</p>
        <p><strong>Transaction ID:</strong> {{ $order->transaction_id ?? 'N/A' }}</p>
        <p><strong>Tracking ID:</strong> {{ $order->tracking_id ?? 'Not updated' }}</p>
    </div>

    <a href="{{ route('user.orders.index') }}" class="btn btn-secondary">← Back to Orders</a>
</div>
@endsection
