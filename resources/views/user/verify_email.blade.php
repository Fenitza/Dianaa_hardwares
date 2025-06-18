@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h2 class="mb-4">Verify Your Email Address</h2>

            @if (session('resent'))
                <div class="alert alert-success">
                    A fresh verification link has been sent to your email address.
                </div>
            @endif

            <p>
                Before proceeding, please check your email for a verification link.
                If you did not receive the email, click the button below to request another.

</br>   Please do not close this browser or use incognito/private mode. Click the verification link in the same browser to complete registration.
            </p>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-link">Resend Verification Email</button>
            </form>
        </div>
    </div>
</div>
@endsection 
