<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Order;

class RazorpayController extends Controller
{
    public function createOrder(Request $request)
    {
        $internalOrderId = $request->order_id;
    $amount = $request->amount;

    $api = new \Razorpay\Api\Api(config('services.razorpay.key'), config('services.razorpay.secret'));

    $razorpayOrder = $api->order->create([
        'receipt' => $internalOrderId,
        'amount' => $amount,
        'currency' => 'INR',
    ]);

    // ✅ Store razorpay order id in your order table
    \App\Models\Order::where('order_id', $internalOrderId)->update([
        'razorpay_order_id' => $razorpayOrder['id']
    ]);

    return response()->json([
        'id' => $razorpayOrder['id'],
        'amount' => $razorpayOrder['amount']
    ]);
}
}
