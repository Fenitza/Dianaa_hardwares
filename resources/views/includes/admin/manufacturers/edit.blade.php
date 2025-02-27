@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Manufacturer</h1>
    <form action="{{ route('admin.manufacturers.update', $manufacturer->ManufacturerID) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required value="{{ $manufacturer->Name }}">
                </div>
                <div class="form-group mb-3">
                    <label for="manufacturer_image">Manufacturer Image</label>
                    <input type="file" class="form-control-file" id="manufacturer_image" name="manufacturer_image" onchange="previewImage(event)">
                    <div id="image_preview_container" style="margin-top: 20px;">
                        <img id="image_preview" src="{{ asset('storage/' . $manufacturer->Image) }}" alt="Image Preview" style="width: 100%; display: block;"/>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Manufacturer</button>
            </div>
        </div>
    </form>
</div>

@endsection
