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

        <h3 class="page-title">Manage Subcategories <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary">Add New Subcategory</a></h3>
        
        <div class="tools">
        <form action="{{ route('admin.subcategories') }}" method="GET" class="form-inline">
            <div class="sort">
                <label for="sort" class="sort-label">Sort by:</label>
                <select id="sort" onchange="sortSubcategories(this.value)">
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
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subcategories as $subcategory)
            <tr>
                <td>{{ $subcategory->SubCategoryID }}</td>
                <td><img src="{{ asset('storage/' . $subcategory->Image) }}" alt="Subcategory Image" class="product-img" style="width: 100px; height: 40px; object-fit: contain;"></td>
                <td>{{ $subcategory->Name }}</td>
                <td>{{ $subcategory->category->Name }}</td>
                <td class="actions">
                    <a href="{{ route('admin.subcategories.edit', $subcategory->SubCategoryID) }}" class="btn btn-info">Edit</a>
                    <form action="{{ route('admin.subcategories.delete', $subcategory->SubCategoryID) }}" method="POST" style="display:inline;">
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
<div class="mt-4 pagination">
    {{ $subcategories->appends(['search' => request('search'), 'perPage' => request('perPage')])->links() }}
</div>
</div>

<script>
function sortSubcategories(sortValue) {
    // Implement sorting logic or update URL with sorting params
    // Example of redirecting with sorting parameters
    window.location.href = `{{ url('admin/subcategories') }}?sort=${sortValue}&search=${document.getElementById('search').value}&perPage=${document.getElementById('perPage').value}`;
}
</script>

@endsection
