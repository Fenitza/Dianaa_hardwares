@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Add New Job</h2>

    <form action="{{ route('admin.careers.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="title">Job Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="location">Location</label>
            <input type="text" name="location" class="form-control" value="{{ old('location') }}">
        </div>

        <div class="form-group mb-3">
            <label for="description">Job Description</label>
            <textarea name="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Post Job</button>
        <a href="{{ route('admin.careers.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
