@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Job Postings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.careers.create') }}" class="btn btn-primary mb-3">Add New Job</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Location</th>
                <th>Posted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
                <tr>
                    <td>{{ $job->title }}</td>
                    <td>{{ $job->location ?? 'N/A' }}</td>
                    <td>{{ $job->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.careers.edit', $job->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.careers.destroy', $job->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this job?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
