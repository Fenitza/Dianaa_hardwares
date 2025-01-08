<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function account()
    {
        // Assuming the user is authenticated and you are using the Auth facade
        $user = auth()->user();

        // Return the account view, passing the user data
        return view('user.account', ['user' => $user]);
    }
}
