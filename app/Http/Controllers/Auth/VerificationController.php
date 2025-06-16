<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerificationController extends Controller
{
    // Show verify email notice
    public function notice()
    {
        return view('user.verify_email');
    }

    // Handle verification link
    public function verify(EmailVerificationRequest $request)
{
    $request->fulfill();

    // Check if user doesn't have a password set
    if (is_null($request->user()->password)) {
        return redirect()->route('register.complete');
    }

    return redirect('/home');
}


    // Resend verification email
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/home');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}
