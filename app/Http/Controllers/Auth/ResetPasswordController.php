<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    // Optionally, override any methods here that you want to customize the behavior of.
    
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ];
    }

    protected function validationErrorMessages()
    {
        return [
            'email.required' => 'Please provide your email address.',
            'password.required' => 'Please enter a password.',
            'password.confirmed' => 'Passwords do not match.',
            'password.min' => 'The password must be at least 8 characters.',
        ];
    }

    public function showResetForm(Request $request, $token = null)
{
    return view('user.reset_password')->with([
        'token' => $token,
        'email' => $request->email,
    ]);
}
}
