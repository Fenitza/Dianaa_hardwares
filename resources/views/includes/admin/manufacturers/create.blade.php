@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Add New Manufacturer</h1>
    <form action="{{ route('admin.manufacturers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group mb-3">
                    <label for="manufacturer_image">Manufacturer Image</label>
                    <input type="file" class="form-control-file" id="manufacturer_image" name="manufacturer_image" onchange="previewImage(event)" required>
                    <div id="image_preview_container" style="margin-top: 20px;">
                        <img id="image_preview" alt="Image Preview" style="width: 100%; display: none;"/>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create Manufacturer</button>
            </div>
        </div>
    </form>
</div>

@endsection
