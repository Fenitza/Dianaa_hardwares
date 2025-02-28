@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Subcategory</h1>
    <form action="{{ route('admin.subcategories.update', $subcategory->SubCategoryID) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required value="{{ $subcategory->Name }}">
                </div>
                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ $subcategory->Description }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="category_id">Category</label>
                    <select class="form-control" id="category_id" name="category_id">
                        @foreach ($categories as $category)
                        <option value="{{ $category->CategoryID }}" {{ $category->CategoryID == $subcategory->CategoryID ? 'selected' : '' }}>{{ $category->Name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="subcategory_image">Subcategory Image</label>
                    <input type="file" class="form-control-file" id="subcategory_image" name="subcategory_image" onchange="previewImage(event)">
                    <div id="image_preview_container" style="margin-top: 20px;">
                        @if ($subcategory->Image)
                        <img id="image_preview" src="{{ asset('storage/'.$subcategory->Image) }}" alt="Image Preview" style="width: 100%; display: block;"/>
                        @else
                        <img id="image_preview" alt="Image Preview" style="width: 100%; display: none;"/>
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Subcategory</button>
            </div>
        </div>
    </form>
</div>


@endsection
