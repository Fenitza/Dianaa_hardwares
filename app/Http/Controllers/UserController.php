<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display the user's account page.
     *
     * @return \Illuminate\Http\Response
     */
    public function account()
    {
        $user = Auth::user();  // Get the currently authenticated user
        return view('includes.user.profile', compact('user'));
    }

    /**
     * Show the form for editing the authenticated user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    /**
     * Update the authenticated user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all()); // This will dump all request data and stop the script
        $user = Auth::user(); // Get the currently authenticated user

    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'phone' => 'required|string|max:15', // Adjust validation as necessary
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'postal_code' => 'required|string|max:15',
        'country' => 'required|string|max:255'
    ]);

    // Update user information
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone_number' => $request->phone,
        'billing_address' => $request->address,
        'billing_city' => $request->city,
        'billing_state' => $request->state,
        'billing_postal_code' => $request->postal_code,
        'billing_country' => $request->country
    ]);

    // Redirect back or to another page with a success message
    return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Display a listing of all users. (Admin Access)
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', User::class); // Policy to ensure only admins can view all users
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Update the role of a user. (Admin Access)
     *
     * @param \Illuminate\Http\Request $request
     * @param int $userId
     * @return \Illuminate\Http\Response
     */
    public function updateRole(Request $request, $userId)
    {
        $request->validate([
            'role' => 'required|string|in:admin,user,vendor'  // Ensure the role is valid
        ]);

        $user = User::findOrFail($userId);
        $user->role = $request->role;
        $user->save();

        return back()->with('success', 'User role updated successfully!');
    }
}
