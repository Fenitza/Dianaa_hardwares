{{-- resources/views/search/results.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Search Results for: {{ $query }}</h1>
    @if($results->isEmpty())
        <p>No results found for '{{ $query }}'.</p>
    @else
        <div>
            @foreach ($results as $result)
                <div>{{ $result->name }}</div>
            @endforeach
        </div>
    @endif
@endsection
