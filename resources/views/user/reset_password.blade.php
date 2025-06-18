@extends('layouts.app')

@section('content')
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
