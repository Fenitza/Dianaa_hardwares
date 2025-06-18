@extends('layouts.app')

@section('content')
<style>
    .container {
        max-width: 500px;
        margin: 50px auto;
        padding: 30px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
        margin-bottom: 30px;
        font-weight: 600;
        color: #333;
    }
    .form-group label {
        font-weight: bold;
        color: #555;
    }
    .form-control {
        border-radius: 6px;
        box-shadow: none;
        border: 1px solid #ccc;
    }
    .btn-primary {
        width: 100%;
        border-radius: 6px;
        padding: 10px;
        background-color: #007bff;
        border: none;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    .alert-success {
        text-align: center;
        font-size: 14px;
        padding: 10px;
        margin-bottom: 20px;
    }
</style>

<div class="container">
    <h2>Reset Password</h2>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" value="{{ $email ?? old('email') }}" required class="form-control">
        </div>

        <div class="form-group">
            <label>New Password</label>
            <input type="password" name="password" required class="form-control">
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</div>
@endsection
