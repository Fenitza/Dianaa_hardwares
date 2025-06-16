<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            // 'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'user', // default role
        ]);
    }

    public function showRegistrationForm()
    {
        return view('user.register');
    }

    public function showRegistrationVendor()
    {
        return view('user.register_vendor');
    }

    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required|string|min:8|confirmed',
        ]);

        // Create user
        $user = $this->create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            // 'password' => $validatedData['password'],
            'role' => $request->role,
        ]);

        // Dispatch email verification event
        event(new Registered($user));

        // DO NOT log in the user yet, force them to verify email first
        Auth::login($user);  

        // Redirect to verification notice page
        return redirect()->route('verification.notice')->with('success', 'Verification link sent. Please check your email.');
    }
    public function showCompleteForm()
{
    $user = Auth::user();

    // If password already exists, redirect
    if (!is_null($user->password)) {
        return redirect('/home');
    }

    return view('user.complete_registration'); // create this Blade file
}

public function completeRegistration(Request $request)
{
    $request->validate([
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = Auth::user();
    $user->update([
        'password' => Hash::make($request->password),
    ]);

    return redirect('/home')->with('success', 'Registration completed!');
}

}
