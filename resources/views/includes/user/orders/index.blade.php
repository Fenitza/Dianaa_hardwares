@extends('layouts.user')

@section('content')
<div class="admin-template">
    <div class="header">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <h3 class="page-title">My Orders</h3>

        <div class="tools">
            <form action="{{ route('user.orders.index') }}" method="GET" class="form-inline">
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
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Payment Status</th>
                    <th>Tracking ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>₹{{ number_format($order->total_amount, 2) }}</td>
                        <td>{{ ucfirst($order->payment_status) }}</td>
                        <td>{{ $order->tracking_id ?? 'Pending' }}</td>
                        <td>
                            <a href="{{ route('user.orders.show', $order->order_id) }}" class="btn btn-sm btn-outline-info">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4 pagination-container">
            <nav>
                <ul class="pagination">
                    {{ $orders->appends(['search' => request('search'), 'perPage' => request('perPage')])->links() }}
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection
