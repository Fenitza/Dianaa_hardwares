@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h4 class="mb-4">Order Details: <span class="text-primary">{{ $order->order_id }}</span></h4>

    <div class="row">
        <!-- Order Info -->
        <div class="col-md-6">
            <div class="card p-3 mb-3 shadow-sm">
                <h5 class="border-bottom pb-2">Order Information</h5>
                <p><strong>Order ID:</strong> {{ $order->order_id }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="col-md-6">
            <div class="card p-3 mb-3 shadow-sm">
                <h5 class="border-bottom pb-2">Payment Details</h5>
                <p><strong>Status:</strong> {{ $order->payment_status }}</p>
                <p><strong>Total:</strong> ₹{{ number_format($order->total_amount, 2) }}</p>
                <p><strong>Transaction ID:</strong> {{ $order->transaction_id ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Shipping / Tracking -->
    <div class="card p-3 mb-3 shadow-sm">
        <h5 class="border-bottom pb-2">Shipping & Tracking</h5>
        <form action="{{ route('admin.orders.updateTracking', $order->id) }}" method="POST" class="row g-2">
            @csrf
            @method('PUT')
            <div class="col-md-6">
                <label for="tracking_id" class="form-label">Tracking ID</label>
                <input type="text" name="tracking_id" id="tracking_id" class="form-control" value="{{ $order->tracking_id }}" placeholder="Enter tracking number">
            </div>
            <div class="col-md-2 align-self-end">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>

    <!-- Waybill Info -->
    <div class="card p-3 mb-3 shadow-sm">
        <h5 class="border-bottom pb-2">Waybill Information</h5>
        @if($order->awb_number)
            <p><strong>AWB Number:</strong> {{ $order->awb_number }}</p>
        @else
            <p class="text-muted">AWB not generated yet.</p>
        @endif
    </div>

    <!-- Customer Info -->
    <div class="card p-3 mb-3 shadow-sm">
        <h5 class="border-bottom pb-2">Customer Details</h5>
        <p><strong>Name:</strong> {{ $billingDetails->name ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $billingDetails->email ?? 'N/A' }}</p>
        <p><strong>Phone:</strong> {{ $billingDetails->phone ?? 'N/A' }}</p>
    </div>

    <!-- Shipping Address -->
    <div class="card p-3 mb-3 shadow-sm">
        <h5 class="border-bottom pb-2">Shipping Address</h5>
        <address>
            {{ $billingDetails->address }}<br>
            {{ $billingDetails->city }}, {{ $billingDetails->state }} {{ $billingDetails->postal_code }}<br>
            {{ $billingDetails->country }}
        </address>
    </div>

    <!-- Items -->
    <div class="card p-3 mb-3 shadow-sm">
    <h5 class="border-bottom pb-2">Ordered Items</h5>
    <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle">
            <thead class="table-light">
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
                <!-- Shipping Row -->
                <tr class="table-warning">
                    <td colspan="4" class="text-end"><strong>Shipping Charge</strong></td>
                    <td><strong>₹{{ number_format($order->shipping ?? 0, 2) }}</strong></td>
                </tr>
                <!-- Grand Total Row -->
                <tr class="table-info">
                    <td colspan="4" class="text-end"><strong>Grand Total</strong></td>
                    <td>
                        <strong>
                            ₹{{ number_format(($order->total_amount ?? 0), 2) }}
                        </strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


    <!-- Generate Waybill -->
    <div class="card p-3 mb-3 shadow-sm">
        <h5 class="border-bottom pb-2">Generate Waybill</h5>
        <form action="{{ route('admin.orders.generateWaybill', $order->id) }}" method="POST">
            @csrf
            <div class="row">
                <h6 class="mt-2 mb-3">Shipper Details</h6>
                <div class="col-md-6 mb-2">
                    <label>Shipper Name</label>
                    <input type="text" name="shipper_customer_name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label>Mobile</label>
                    <input type="text" name="shipper_customer_mobile" class="form-control" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label>Email</label>
                    <input type="email" name="shipper_customer_email" class="form-control">
                </div>
                <div class="col-md-6 mb-2">
                    <label>Pincode</label>
                    <input type="text" name="shipper_customer_pincode" class="form-control" required>
                </div>
                <div class="col-md-12 mb-2">
                    <label>Address Line 1</label>
                    <input type="text" name="shipper_customer_address1" class="form-control" required>
                </div>
                <div class="col-md-12 mb-2">
                    <label>Address Line 2</label>
                    <input type="text" name="shipper_customer_address2" class="form-control">
                </div>
                <div class="col-md-12 mb-2">
                    <label>Address Line 3</label>
                    <input type="text" name="shipper_customer_address3" class="form-control">
                </div>
                <div class="col-md-6 mb-2">
                    <label>Origin Area Code</label>
                    <input type="text" name="shipper_origin_area" class="form-control" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label>Pickup Date</label>
                    <input type="date" name="pickup_date" class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">🚚 Generate Waybill</button>
        </form>
    </div>

    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-3">⬅ Back to Orders</a>
</div>
@endsection
