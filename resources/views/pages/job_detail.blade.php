@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2>{{ $job->title }}</h2>
    <p><strong>Location:</strong> {{ $job->location }}</p>
    <p><strong>Description:</strong> {{ $job->description }}</p>

    <h4 class="mt-4">Apply for this Job</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('careers.apply', $job->id) }}">
        @csrf
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Qualification:</label>
            <input type="qualification" name="qualification" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Phone:</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <div class="mb-3">
            <label>Message:</label>
            <textarea name="message" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Application</button>
    </form>
</div>
@endsection
