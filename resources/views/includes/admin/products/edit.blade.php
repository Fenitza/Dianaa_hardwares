@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="sticky-toolbar">
        <button type="submit" form="product-form" class="btn btn-primary">Save Changes</button>
    </div>
    <div class="row" id="edit-product-container">
        <div class="col-md-8">
            <form id="product-form" method="POST" action="{{ route('admin.products.update', $product->ProductID) }}">
                @csrf
                @method('PUT') {{-- Method Spoofing to handle PUT request --}}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $product->Name }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ $product->Description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="sku">SKU</label>
                    <input type="text" class="form-control" id="sku" name="sku" value="{{ $product->SKU }}" required>
                </div>
                <div class="form-group">
                    <label for="salePrice">Sale Price</label>
                    <input type="number" class="form-control" id="salePrice" name="salePrice" value="{{ $product->SalePrice }}" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $product->Quantity }}" required>
                </div>
                <div class="form-group">
                    <label for="size">Size</label>
                    <input type="text" class="form-control" id="size" name="size" value="{{ $product->Size }}">
                </div>
                <div class="form-group">
                    <label for="length">Length</label>
                    <input type="text" class="form-control" id="length" name="length" value="{{ $product->Length }}">
                </div>
                <div class="form-group">
                    <label for="property_class">Property Class</label>
                    <input type="text" class="form-control" id="property_class" name="property_class" value="{{ $product->Property_Class }}">
                </div>
                <div class="form-group">
                    <label for="standard">Standard</label>
                    <input type="text" class="form-control" id="standard" name="standard" value="{{ $product->Standard }}">
                </div>
                <div class="form-group">
                    <label for="material">Material</label>
                    <input type="text" class="form-control" id="material" name="material" value="{{ $product->Material }}">
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="product_image">Product Image</label>
                <input type="file" class="form-control-file" id="product_image" name="product_image">
                <div id="image_preview_container" style="width: 100%; height: 300px; overflow: hidden;">
                    <img id="image_preview" src="{{ $product->image_url }}" alt="Image Preview" style="width: 100%; display: block;"/>
                </div>
            </div>
            <div class="form-group">
                <label for="ManufacturerID">Manufacturer</label>
                <input type="text" class="form-control" id="ManufacturerID" name="ManufacturerID" value="{{ $product->Manufacturer }}" required>
            </div>
            <div class="form-group">
                <label for="SubCategoryID">Category</label>
                <select class="form-control" id="SubCategoryID" name="SubCategoryID">
                @foreach ($subcategories as $subcategory)
                    <option value="{{ $subcategory->SubCategoryID }}" {{ $product->SubCategoryID == $subcategory->SubCategoryID ? 'selected' : '' }}>{{ $subcategory->Name }}</option>
                @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
@endsection
