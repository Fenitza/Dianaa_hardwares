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

        <h3 class="page-title">Manage Manufacturers <a href="{{ route('admin.manufacturers.create') }}" class="btn btn-primary">Add New Manufacturer</a></h3>
        
        <div class="tools">
        <form action="{{ route('admin.manufacturers') }}" method="GET" class="form-inline">
            <div class="sort">
                <label for="sort" class="sort-label">Sort by:</label>
                <select id="sort" onchange="sortManufacturers(this.value)">
                    <option value="name">Name</option>
                    <option value="newest">Newest</option>
                </select>
            </div>

            <div class="form-group">
                <label for="search" class="mr-sm-2">Search:</label>
                <input type="text" id="search" name="search" class="form-control" placeholder="Search by name" value="{{ request('search') }}">
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
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($manufacturers as $manufacturer)
            <tr>
                <td>{{ $manufacturer->ManufacturerID }}</td>
                <td><img src="{{ asset('storage/' . $manufacturer->Image) }}" alt="Manufacturer Image" class="product-img" style="width: 100px; height: 40px; object-fit: contain;"></td>
                <td>{{ $manufacturer->Name }}</td>
                <td class="actions">
                    <a href="{{ route('admin.manufacturers.edit', $manufacturer->ManufacturerID) }}" class="btn btn-info">Edit</a>
                    <form action="{{ route('admin.manufacturers.delete', $manufacturer->ManufacturerID) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $manufacturers->appends(['search' => request('search'), 'perPage' => request('perPage')])->links() }}
    </div>
</div>

<script>
function sortManufacturers(sortValue) {
    // Implement sorting logic or update URL with sorting params
    // Example of redirecting with sorting parameters
    window.location.href = `{{ url('admin/manufacturers') }}?sort=${sortValue}&search=${document.getElementById('search').value}&perPage=${document.getElementById('perPage').value}`;
}
</script>

@endsection
