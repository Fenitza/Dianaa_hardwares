@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="sticky-toolbar">
        <button type="submit" form="product-form" class="btn btn-primary">Save Changes</button>
    </div>
    <div class="row" id="edit-product-container">
        <div class="col-md-8">
            <form id="product-form" method="POST" action="{{ route('admin.products.update', $product->ProductID) }}" enctype="multipart/form-data">
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
                    <input type="decimal" class="form-control" id="salePrice" name="salePrice" value="{{ $product->SalePrice }}" required>
                </div>
                <div class="form-group">
                    <label for="vendorPrice">Vendor Price</label>
                    <input type="decimal" class="form-control" id="vendorPrice" name="vendorPrice" value="{{ $product->VendorPrice }}" required>
                </div>
                <div class="form-group">
                    <label for="basePrice">Base Price</label>
                    <input type="number" step="0.01" class="form-control" id="basePrice" name="basePrice" value="{{ $product->BasePrice }}" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" step="0.01" class="form-control" id="quantity" name="quantity" value="{{ $product->Quantity }}" required>
                </div>
                <div class="form-group">
                    <label for="size">Size</label>
                    <input type="text"  class="form-control" id="size" name="size" value="{{ $product->Size }}">
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
            </div>
            <div class="col-md-4">
                <div class="form-group">
                <label for="product_image">Product Images</label>
                <input type="file" class="form-control-file" id="image_path" name="image_path[]" multiple required>
                <div id="file-name-display" class="mt-2"></div> <!-- Container to display file names -->
                <div id="image-preview-container" class="mt-2"></div>
            </div>
                <div class="form-group">
                    <label for="ManufacturerID">Manufacturer</label>
                    <select class="form-control" id="ManufacturerID" name="ManufacturerID">
                        @foreach ($manufacturers as $manufacturer)
                            <option value="{{ $manufacturer->ManufacturerID }}" {{ $product->ManufacturerID == $manufacturer->ManufacturerID ? 'selected' : '' }}>{{ $manufacturer->Name }}</option>
                        @endforeach
                    </select>
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
        </form>
    </div>
</div>
@endsection


