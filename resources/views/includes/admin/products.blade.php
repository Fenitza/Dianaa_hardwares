@extends('layouts.admin')

@section('content')
<div class="container">
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

        <h1 class="page-title">Manage Products</h1>
        <div class="admin-template">
            <div class="tools">
                <div class="sort">
                    <label for="sort">Sort by:</label>
                    <select id="sort" onchange="sortProducts(this.value)">
                        <option value="name">Name</option>
                        <option value="quantity">Quantity</option>
                        <option value="category">Category</option>
                    </select>
                </div>
                <button class="btn btn-secondary" onclick="performBulkOperation()">Bulk Delete</button>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add New Product</a>
            </div>
        </div>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all"></th> <!-- Checkbox for bulk selection -->
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>SKU</th>
                <th class="price">Sale Price</th>
                <th class="price">Vendor Price</th>
                <th>Stock Status</th>
                <th>Quantity</th>
                <th>Category</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody style="text-align: center;">
            @foreach ($products as $product)
            <tr>
                <td><input type="checkbox" name="selected_products[]" value="{{ $product->ProductID }}"></td> <!-- Individual row selection -->
                <td>{{ $product->ProductID }}</td>
                <td><img src="{{ asset('storage/' . $product->product_image) }}" alt="Product Image" class="product-img" style="width: 100px; height: 75px; object-fit: contain;"></td>
                <td>{{ $product->Name }}</td>
                <td>{{ $product->SKU }}</td>
                <td class="price">₹{{ $product->SalePrice }}</td>
                <td class="price">₹{{ $product->VendorPrice }}</td>
                <td class="stock-status {{ $product->Quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                    {{ $product->Quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                </td>
                <td>{{ $product->Quantity }}</td>
                <td>{{ $product->subCategory ? $product->subCategory->Name : 'No subcategory' }}</td>
                <td class="actions">
                    <a href="{{ route('admin.products.view', $product->ProductID) }}" class="action-icon view"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('admin.products.edit', $product->ProductID) }}" class="action-icon edit"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.products.delete', $product->ProductID) }}" method="POST" onsubmit="return confirm('This product will be deleted permanently. Are you sure you want to delete this product?')">
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
</div>
@endsection
