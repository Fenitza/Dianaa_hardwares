<?php

namespace App\Http\Controllers;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }


public function submit(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'nullable',
        'message' => 'required',
    ]);

    // Send email
    Mail::to('dianaafastners@gmail.com',
    'benedict@dhw.co.in',
                'nirmal@dhw.co.in',
                'dianaadigital2024@gmail.com')->send(new ContactFormMail($validated));

    return back()->with('success', 'Your message has been sent!');
}

}
