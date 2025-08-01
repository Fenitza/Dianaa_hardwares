@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Order Details: {{ $order->order_id }}</h4>

    <div class="card p-3 mb-3">
        <h5>Order Details</h5>
        <p><strong>Order ID:</strong> {{ $order->order_id }}</p>
        <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}</p>
    </div>

    <div class="card p-3 mb-3">
        <h5>Payment Info</h5>
        <p><strong>Status:</strong> {{ $order->payment_status }}</p>
        <p><strong>Total Amount:</strong> ₹{{ number_format($order->total_amount, 2) }}</p>
        <p><strong>Transaction ID:</strong> {{ $order->transaction_id ?? 'N/A' }}</p>
    </div>
    
    <div class="card p-3 mb-3">
        <h5>Shipping / Tracking</h5>
        <form action="{{ route('admin.orders.updateTracking', $order->id) }}" method="POST" class="form-inline">
            @csrf
            @method('PUT')
            <div class="form-group me-2">
                <label for="tracking_id" class="me-2">Tracking ID:</label>
                <input type="text" name="tracking_id" id="tracking_id" class="form-control" 
                    value="{{ $order->tracking_id }}" placeholder="Enter tracking number">
            </div>
            <button type="submit" class="btn btn-sm btn-success">Update</button>
        </form>
    </div>

    <div class="card p-3 mb-3">
        <h5>Customer Info</h5>
        <p><strong>Name:</strong> {{ $billingDetails->name ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $billingDetails->email ?? 'N/A' }}</p>
        <p><strong>Phone:</strong> {{ $billingDetails->phone ?? 'N/A' }}</p>
    </div>

    <div class="card p-3 mb-3">
        <h5>Shipping Address</h5>
        <p>
            {{ $billingDetails->address }}<br>
            {{ $billingDetails->city }}, {{ $billingDetails->state }} {{ $billingDetails->postal_code }}<br>
            {{ $billingDetails->country }}
        </p>
    </div>

    <div class="card p-3 mb-3">
        <h5>Items</h5>
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Manufacturer</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
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

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card p-3 mb-3">
    <h5>Generate Waybill</h5>
    <form action="{{ route('admin.orders.generateWaybill', $order->id) }}" method="POST">
        @csrf
        <div class="form-group mb-2">
            <label for="pickup_date" class="form-label">Select Pickup Date</label>
            <input type="date" name="pickup_date" id="pickup_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">🚚 Generate Waybill</button>
    </form>
</div>

    

    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-3">⬅ Back to Orders</a>
</div>
@endsection
