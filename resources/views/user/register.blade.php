@extends('layouts.app')

@section('content')
<div class="container auth-container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card auth-card">
                <div class="card-header auth-card-header text-center">
                    {{ __('Register as Customer') }}
                </div>

                <div class="card-body auth-form">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">{{ __('Full Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password" required>
                            @error('password')
                                <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" 
                                   name="password_confirmation" required>
                        </div> -->

                        <input type="hidden" name="role" value="user">
 
                        <div class="form-group text-center mt-3">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        Already registered? <a href="{{ route('login') }}">Login here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
