@extends('layouts.user')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-white text-dark">
            <h2 class="mb-0">My Profile</h2>
        </div>
        <div class="card-body bg-light">
            <form method="POST" action="{{ route('profile.update') }}" class="p-4">
                @csrf
                @method('PATCH')

                <div class="row mb-3">
                    <label for="name" class="col-sm-3 col-form-label"><i class="fas fa-user"></i> Full Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ Auth::user()->name ?? '' }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-sm-3 col-form-label"><i class="fas fa-envelope"></i> Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ Auth::user()->email ?? '' }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="phone" class="col-sm-3 col-form-label"><i class="fas fa-phone"></i> Mobile</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="phone" name="phone"
                               value="{{ Auth::user()->phone_number ?? '' }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="address" class="col-sm-3 col-form-label"><i class="fas fa-home"></i> Billing Address</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="address" name="address" 
                               value="{{ Auth::user()->billing_address ?? '' }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="city" class="col-sm-3 col-form-label"><i class="fas fa-city"></i> City</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="city" name="city" 
                               value="{{ Auth::user()->billing_city ?? '' }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="state" class="col-sm-3 col-form-label"><i class="fas fa-map-marker-alt"></i> State</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="state" name="state" 
                               value="{{ Auth::user()->billing_state ?? '' }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="postal_code" class="col-sm-3 col-form-label"><i class="fas fa-mail-bulk"></i> Postal Code</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="postal_code" name="postal_code" 
                               value="{{ Auth::user()->billing_postal_code ?? '' }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="country" class="col-sm-3 col-form-label"><i class="fas fa-globe-americas"></i> Country</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="country" name="country" 
                               value="{{ Auth::user()->billing_country ?? '' }}" required>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
