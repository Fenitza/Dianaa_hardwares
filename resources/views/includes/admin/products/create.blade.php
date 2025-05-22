@extends('layouts.admin')

@section('content')
@include('partials.alert')

<div class="container mt-4">
    <form id="product-form" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Add New Product</h5>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>

            <div class="card-body">
                <div class="row g-4">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">Item Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="slno">Sl No.</label>
                            <input type="number" class="form-control" id="slno" name="slno" required>
                        </div>

                        <div class="form-group">
                            <label for="sku">Part Number</label>
                            <input type="text" class="form-control" id="sku" name="sku" required>
                        </div>

                        <div class="form-group">
                            <label for="chapterID">Chapter ID</label>
                            <input type="text" class="form-control" id="chapterID" name="chapterID" required>
                        </div>

                        <div class="form-group">
                            <label for="ManufacturerID">Manufacturer</label>
                            <select class="form-control" id="ManufacturerID" name="ManufacturerID" required>
                                @foreach ($manufacturers as $manufacturer)
                                <option value="{{ $manufacturer->ManufacturerID }}">{{ $manufacturer->Name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="SubCategoryID">Sub Category</label>
                            <select class="form-control" id="SubCategoryID" name="SubCategoryID" required>
                                @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->SubCategoryID }}">{{ $subcategory->Name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image_path">Product Images</label>
                            <input type="file" class="form-control-file" id="image_path" name="image_path[]" multiple required>
                            <div id="file-name-display" class="mt-2"></div> <!-- Container to display file names -->
                            <div id="image-preview-container" class="mt-2"></div>
                        </div>

                        <div class="form-group">
                            <label for="salePrice">Sale Price</label>
                            <input type="number" step="0.01" class="form-control" id="salePrice" name="salePrice" required>
                        </div>

                        <div class="form-group">
                            <label for="vendorPrice">Vendor Price</label>
                            <input type="number" step="0.01" class="form-control" id="vendorPrice" name="vendorPrice" required>
                        </div>

                        <!-- <div class="form-group">
                            <label for="basePrice">Base Price</label>
                            <input type="number" step="0.01" class="form-control" id="basePrice" name="basePrice" required>
                        </div> -->

                        <div class="form-group">
                            <label for="discount">Discount %</label>
                            <input type="number" step="0.01" class="form-control" id="discount" name="discount">
                        </div>

                        <div class="form-group">
                            <label for="moq">MOQ</label>
                            <input type="number" class="form-control" id="moq" name="moq">
                        </div>

                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity">
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="standardISO">Standard (ISO / DIN)</label>
                            <input type="text" class="form-control" id="standardISO" name="standardISO">
                        </div>

                        <div class="form-group">
                            <label for="grade">Grade</label>
                            <input type="text" class="form-control" id="grade" name="grade">
                        </div>

                        <div class="form-group">
                            <label for="size">Thread Size</label>
                            <input type="text" class="form-control" id="size" name="size">
                        </div>

                        <div class="form-group">
                            <label for="pitch">Pitch</label>
                            <input type="number" step="0.01" class="form-control" id="pitch" name="pitch">
                        </div>

                        <div class="form-group">
                            <label for="pitchType">Pitch Type</label>
                            <select class="form-control" id="pitchType" name="pitchType">
                                <option value="Fine Pitch">Fine Pitch</option>
                                <option value="Nil">Nil</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="length">Length</label>
                            <input type="text" class="form-control" id="length" name="length">
                        </div>

                        <div class="form-group">
                            <label for="weight">Weight</label>
                            <input type="number" step="0.01" class="form-control" id="weight" name="weight">
                        </div>

                        <div class="form-group">
                            <label for="threadType">Full Thread / Half Thread</label>
                            <select class="form-control" id="threadType" name="threadType">
                                <option value="Full Thread">Full Thread</option>
                                <option value="Half Thread">Half Thread</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="color">Colour</label>
                            <input type="text" class="form-control" id="color" name="color">
                        </div>

                        <div class="form-group">
                            <label for="metric">Metric / Inches</label>
                            <select class="form-control" id="metric" name="metric">
                                <option value="MM">MM</option>
                                <option value="Inches">Inches</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="standardType">UNC / UNF / BSF / BSW</label>
                            <input type="text" class="form-control" id="standardType" name="standardType">
                        </div>

                        <div class="form-group">
                            <label for="point">Cone / Cup / Flat Points</label>
                            <select class="form-control" id="point" name="point">
                                <option value="Cone ">Cone Point</option>
                                <option value="Cup">Cup Point</option>
                                <option value="Flat">Flat Point</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="type">Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="Featured">Featured</option>
                                <option value="Best Sellers">Best Sellers</option>
                                <option value="New Arrivals">New Arrivals</option>
                            </select>
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- card-body -->
        </div> <!-- card -->
    </form>
</div>


@endsection