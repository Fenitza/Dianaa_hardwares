@extends('layouts.admin')

@section('content')
@include('partials.alert')
<div class="container mt-4">
    <div class="sticky-toolbar">
        <button type="submit" form="product-form" class="btn btn-primary">Save</button>
    </div>
    <div class="row" id="add-product-container">
        <div class="col-md-8">
            <form id="product-form" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="sku">SKU</label>
                    <input type="text" class="form-control" id="sku" name="sku" required>
                </div>
                <div class="form-group">
                    <label for="salePrice">Sale Price</label>
                    <input type="number" step="0.01" class="form-control" id="salePrice" name="salePrice" required>
                </div>
                
                <div class="form-group">
                    <label for="vendorPrice">Vendor Price</label>
                    <input type="number" step="0.01" class="form-control" id="vendorPrice" name="vendorPrice" required>
                </div>

                <div class="form-group">
                    <label for="basePrice">Base Price</label>
                    <input type="number" step="0.01" class="form-control" id="basePrice" name="basePrice" required>
                </div>
                
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                </div>
                <div class="form-group">
                    <label for="size">Size</label>
                    <input type="text" class="form-control" id="size" name="size">
                </div>
                <div class="form-group">
                    <label for="length">Length</label>
                    <input type="text" class="form-control" id="length" name="length">
                </div>
                <div class="form-group">
                    <label for="property_class">Property Class</label>
                    <input type="text" class="form-control" id="property_class" name="property_class">
                </div>
                <div class="form-group">
                    <label for="standard">Standard</label>
                    <input type="text" class="form-control" id="standard" name="standard">
                </div>
                <div class="form-group">
                    <label for="material">Material</label>
                    <input type="text" class="form-control" id="material" name="material">
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
                <!-- Manufacturer Select -->
                <select class="form-control" id="ManufacturerID" name="ManufacturerID">
                    @foreach ($manufacturers as $manufacturer)
                        <option value="{{ $manufacturer->ManufacturerID }}">{{ $manufacturer->Name }}</option>
                    @endforeach
                </select>
                <!-- <label for="ManufacturerID">Manufacturer</label>
                    <input type="text" class="form-control" id="ManufacturerID" name="ManufacturerID" required> -->
            </div>
            <div class="form-group">
                <label for="SubCategoryID">Category</label>
                <select class="form-control" id="SubCategoryID" name="SubCategoryID">
                @foreach ($subcategories as $subcategory)
                    <option value="{{ $subcategory->SubCategoryID }}">{{ $subcategory->Name }}</option>
                @endforeach
            </select>
            </div>
    </form>
    </div>
    </div>
</div>
@endsection

