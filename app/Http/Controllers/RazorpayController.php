<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    public function createOrder(Request $request)
    {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $order = $api->order->create([
            'receipt'         => 'DianaaFasteners_' . time(),
            'amount'          => $request->amount, // in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto-capture
        ]);

        return response()->json($order);
    }
}
