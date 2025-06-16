@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Complete Your Registration</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register.complete.submit') }}">
                        @csrf

                        <div class="form-group">
                            <label for="password">Create Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3">Complete Registration</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
