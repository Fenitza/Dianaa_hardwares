{{-- resources/views/user/account.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Account Details</h1>
    <p>Name: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p>
    {{-- Add more user details as needed --}}
@endsection
