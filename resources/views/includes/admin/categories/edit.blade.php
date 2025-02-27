@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Category</h1>
    <form action="{{ route('admin.categories.update', $category->CategoryID) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Specify the HTTP method to use when submitting the form -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $category->Name }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ $category->Description }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="category_image">Category Image</label>
                    <input type="file" class="form-control-file" id="category_image" name="category_image" onchange="previewImage(event)">
                    <div id="image_preview_container" style="margin-top: 20px;">
                        <!-- Show current category image if available -->
                        <img id="image_preview" src="{{ $category->image ? asset('storage/' . $category->category_image) : '' }}" alt="Image Preview" style="width: 100%; {{ $category->category_image ? '' : 'display: none;'}}"/>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Category</button>
            </div>
        </div>
    </form>
</div>


@endsection
