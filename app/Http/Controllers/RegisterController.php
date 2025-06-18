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
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailLink;

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
    public function verify(Request $request)
{
    // Check if the link is valid
    if (! $request->hasValidSignature()) {
        abort(403, 'Invalid or expired verification link.');
    }

    // Show password set form
    return view('user.complete_registration', [
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
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
    // Validate request
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
    ]);

    // Generate signed verification URL with user data as query
    $verificationUrl = URL::temporarySignedRoute(
        'register.verify',
        now()->addMinutes(60),
        [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $request->role,
        ]
    );

    // Send verification email
    Mail::to($validatedData['email'])->send(new VerifyEmailLink($verificationUrl));

    return redirect()->back()->with('success', 'Verification link sent to email. Please verify to complete registration.');
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

    $validated = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'role' => 'nullable',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'role' => $validated['role'],
        'password' => bcrypt($validated['password']),
        'email_verified_at' => now(),
    ]);

    Auth::login($user);

    return redirect()->route('home')->with('success', 'Registration complete. Welcome!');
}


} 
