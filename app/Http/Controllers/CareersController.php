<?php

namespace App\Http\Controllers;
use App\Models\Job;
use Illuminate\Http\Request;

class CareersController extends Controller
{
    public function index()
    {
        return view('pages.careers');

    }
    public function showCareersPage()
    {
        $jobs = Job::all(); // Assuming you have a Job model that retrieves data from a jobs table
        return view('pages.careers', ['jobs' => $jobs]);
    }
}
