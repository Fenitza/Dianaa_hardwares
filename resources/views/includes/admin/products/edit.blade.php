@extends('layouts.admin')

@section('content')
@include('partials.alert')

<div class="container mt-4">
    <form id="product-form" method="POST" action="{{ route('admin.products.update', $product->ProductID) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Product</h5>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>

            <div class="card-body">
                <div class="row g-4">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">Item Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ $product->Description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="slno">Sl No.</label>
                            <input type="text" class="form-control" id="slno" name="slno" value="{{ $product->slno }}" required>
                        </div>

                        <div class="form-group">
                            <label for="sku">Part Number</label>
                            <input type="text" class="form-control" id="sku" name="sku" value="{{ $product->SKU }}" required>
                        </div>

                        <div class="form-group">
                            <label for="chapterID">Chapter ID</label>
                            <input type="text" class="form-control" id="chapterID" name="chapterID" value="{{ $product->chapterID }}" required>
                        </div>

                        <div class="form-group">
                            <label for="ManufacturerID">Manufacturer</label>
                            <select class="form-control" id="ManufacturerID" name="ManufacturerID" required>
                                @foreach ($manufacturers as $manufacturer)
                                    <option value="{{ $manufacturer->ManufacturerID }}" @if ($product->ManufacturerID == $manufacturer->ManufacturerID) selected @endif>
                                        {{ $manufacturer->Name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="SubCategoryID">Sub Category</label>
                            <select class="form-control" id="SubCategoryID" name="SubCategoryID" required>
                                @foreach ($subcategories as $subcategory)
                                    <option value="{{ $subcategory->SubCategoryID }}" @if ($product->SubCategoryID == $subcategory->SubCategoryID) selected @endif>
                                        {{ $subcategory->Name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                <label for="product_image">Product Images</label>
                <input type="file" class="form-control-file" id="image_path" name="image_path[]" multiple >
                <div id="file-name-display" class="mt-2"></div> <!-- Container to display file names -->
                <div id="image-preview-container" class="mt-2">
                     {{-- Display existing images --}}
                     @php
                        
                        $images = json_decode($product->image_paths, true); // Assuming images are stored as JSON
                    @endphp
                    @foreach ($images as $image)
                        <img src="{{ Storage::url($image) }}" alt="Image preview" style="max-width: 100px; max-height: 100px; margin-right: 10px;">
                    @endforeach
                </div>
                        </div>

                        <div class="form-group">
                            <label for="salePrice">Sale Price</label>
                            <input type="number" step="0.01" class="form-control" id="salePrice" name="salePrice" value="{{ $product->SalePrice }}" required>
                        </div>

                        <div class="form-group">
                            <label for="vendorPrice">Vendor Price</label>
                            <input type="number" step="0.01" class="form-control" id="vendorPrice" name="vendorPrice" value="{{ $product->VendorPrice }}" required>
                        </div>

                        <div class="form-group">
                            <label for="basePrice">Base Price</label>
                            <input type="number" step="0.01" class="form-control" id="basePrice" name="basePrice" value="{{ $product->BasePrice }}" required>
                        </div>

                        <div class="form-group">
                            <label for="discount">Discount %</label>
                            <input type="number" step="0.01" class="form-control" id="discount" name="discount" value="{{ $product->discount }}">
                        </div>

                        <div class="form-group">
                            <label for="moq">MOQ</label>
                            <input type="number" class="form-control" id="moq" name="moq" value="{{ $product->moq }}">
                        </div>

                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $product->Quantity }}">
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="standardISO">Standard (ISO / DIN)</label>
                            <input type="text" class="form-control" id="standardISO" name="standardISO" value="{{ $product->standardISO }}">
                        </div>

                        <div class="form-group">
                            <label for="grade">Grade</label>
                            <input type="text" class="form-control" id="grade" name="grade" value="{{ $product->grade }}">
                        </div>

                        <div class="form-group">
                            <label for="size">Thread Size</label>
                            <input type="text" class="form-control" id="size" name="size" value="{{ $product->Size }}">
                        </div>

                        <div class="form-group">
                            <label for="pitch">Pitch</label>
                            <input type="number" step="0.01" class="form-control" id="pitch" name="pitch" value="{{ $product->pitch }}">
                        </div>

                        <div class="form-group">
                            <label for="pitchType">Pitch Type</label>
                            <select class="form-control" id="pitchType" name="pitchType">
                                <option value="Fine Pitch" @if ($product->pitchType === 'Fine Pitch') selected @endif>Fine Pitch</option>
                                <option value="Nil" @if ($product->pitchType === 'Nil') selected @endif>Nil</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="length">Length</label>
                            <input type="text" class="form-control" id="length" name="length" value="{{ $product->Length }}">
                        </div>

                        <div class="form-group">
                            <label for="weight">Weight</label>
                            <input type="number" step="0.01" class="form-control" id="weight" name="weight" value="{{ $product->weight }}">
                        </div>

                        <div class="form-group">
                            <label for="threadType">Full Thread / Half Thread</label>
                            <input type="text" class="form-control" id="threadType" name="threadType" value="{{ $product->threadType }}">
                        </div>

                        <div class="form-group">
                            <label for="color">Colour</label>
                            <input type="text" class="form-control" id="color" name="color" value="{{ $product->Color }}">
                        </div>

                        <div class="form-group">
                            <label for="metric">Metric / Inches</label>
                            <input type="text" class="form-control" id="metric" name="metric" value="{{ $product->metric }}">
                        </div>

                        <div class="form-group">
                            <label for="standardType">UNC / UNF / BSF / BSW</label>
                            <input type="text" class="form-control" id="standardType" name="standardType" value="{{ $product->standardType }}">
                        </div>

                        <div class="form-group">
                            <label for="point">Cone / Cup / Flat Points</label>
                            <select class="form-control" id="point" name="point">
                                <option value="Cone" @if ($product->point === 'Cone') selected @endif>Cone</option>
                                <option value="Cup" @if ($product->point === 'Cup') selected @endif>Cup</option>
                                <option value="Flat" @if ($product->point === 'Flat') selected @endif>Flat</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="type">Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="Featured" @if ($product->type === 'Featured') selected @endif>Featured</option>
                                <option value="Best Sellers" @if ($product->type === 'Best Sellers') selected @endif>Best Sellers</option>
                                <option value="New Arrivals" @if ($product->type === 'New Arrivals') selected @endif>New Arrivals</option>
                            </select>
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- card-body -->
        </div> <!-- card -->
    </form>
</div>

<!-- Optional CSS for Image Previews -->
<style>
.img-preview {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 4px;
    margin-right: 10px;
}
</style>
@endsection
