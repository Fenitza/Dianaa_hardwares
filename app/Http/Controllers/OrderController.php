<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('includes.admin.orders');  // Points to resources/views/includes/admin/products.blade.php
    }
}
