@extends('layouts.admin')

@section('content')
<div class="admin-template">
<div class="header">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h3 class="page-title">Manage Orders</h3>

    <div class="tools">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="form-inline">
            <div class="form-group">
                <label for="search" class="mr-sm-2">Search:</label>
                <input type="text" id="search" name="search" class="form-control" placeholder="Search by order ID" value="{{ request('search') }}">
            </div>

            <div class="form-group">
                <label for="perPage" class="mr-sm-4">Entries per page:</label>
                <select id="perPage" name="perPage" class="form-control">
                    <option value="5" {{ request('perPage') == '5' ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('perPage') == '10' ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('perPage') == '20' ? 'selected' : '' }}>20</option>
                    <option value="100" {{ request('perPage') == '100' ? 'selected' : '' }}>100</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Order Date</th>
                <th>Shipping Address</th>
                <th>Total Amount</th>
                <th>Payment Status</th>
                <th>Action</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->order_id }}</td>
                <td>{{ $order->user_name }}</td>
                <td>{{ $order->email }}</td>
                <td>{{ $order->created_at }}</td>
                <td>{!! $order->shipping_address !!}</td>
                <td>{{ $order->total_amount }}</td>
                <td>{{ $order->payment_status }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->order_id) }}" class="btn btn-sm btn-outline-info">
                        View
                    </a>
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="mt-4 pagination-container">
    <nav>
        <ul class="pagination">
        {{ $orders->appends(['search' => request('search'), 'perPage' => request('perPage')])->links() }}
        </ul>
    </nav>
</div>
</div>

@endsection
