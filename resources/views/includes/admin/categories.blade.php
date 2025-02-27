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

        <h3 class="page-title">Manage Categories <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Add New Category</a></h3>
        
        <div class="tools">
        <form action="{{ route('admin.categories') }}" method="GET" class="form-inline">

        <div class="sort">
            <label for="sort" class="sort-label">Sort by:</label>
            <select id="sort" onchange="sortCategories(this.value)">
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
                <option value="20" {{ request('perPage') == '100' ? 'selected' : '' }}>100</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->CategoryID }}</td>
                <td><img src="{{ asset('storage/' . $category->category_image) }}" alt="Category Image" class="product-img" style="width: 100px; height: 40px; object-fit: contain;"></td>
                <td>{{ $category->Name }}</td>
                <td>{{ $category->Description }}</td>
                <td class="actions">
                    <a href="{{ route('admin.categories.edit', $category->CategoryID) }}" class="action-icon edit"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.categories.delete', $category->CategoryID) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-icon delete" style="border: none; background: none;">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $categories->appends(['search' => request('search'), 'perPage' => request('perPage')])->links() }}
    </div>
</div>

<script>
function sortCategories(sortValue) {
    // Implement sorting logic or update URL with sorting params
    // Example of redirecting with sorting parameters
    window.location.href = `{{ url('admin/categories') }}?sort=${sortValue}&search=${document.getElementById('search').value}&perPage=${document.getElementById('perPage').value}`;
}
</script>

@endsection
