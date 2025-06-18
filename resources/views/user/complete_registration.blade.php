@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Complete Your Registration</h4>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.complete') }}">
                        @csrf

                        {{-- Hidden user data passed from signed URL --}}
                        <input type="hidden" name="name" value="{{ $name }}">
                        <input type="hidden" name="email" value="{{ $email }}">
                        <input type="hidden" name="role" value="{{ $role }}">

                        <div class="form-group mb-3">
                            <label for="password">Create Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Complete Registration</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
