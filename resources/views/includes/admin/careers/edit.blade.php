@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Job - {{ $job->title }}</h2>

    <form action="{{ route('admin.careers.update', $job->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="title">Job Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $job->title) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="location">Location</label>
            <input type="text" name="location" class="form-control" value="{{ old('location', $job->location) }}">
        </div>

        <div class="form-group mb-3">
            <label for="description">Job Description</label>
            <textarea name="description" class="form-control" rows="5" required>{{ old('description', $job->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Job</button>
        <a href="{{ route('admin.careers.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
