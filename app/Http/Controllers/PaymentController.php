<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
\DB::enableQueryLog();
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function razorpaySuccess(Request $request)
{
    \Log::info('Razorpay Success Request:', $request->all());

    $razorpayOrderId = $request->razorpay_order_id;

    // Match your stored Razorpay order ID
    $order = \App\Models\Order::where('razorpay_order_id', $razorpayOrderId)->with('items.product')->first();

    if (!$order) {
        \Log::error("❌ No matching order found with Razorpay Order ID: $razorpayOrderId");
        return response()->json(['success' => false]);
    }

    // Update payment status and store transaction
    $order->razorpay_order_id = $request->razorpay_order_id;
    $order->payment_status = 'paid';
    $order->transaction_id = $request->razorpay_payment_id;
    $order->save();

    // Store in session for /checkout/success page
    session(['order' => $order]);

    \Log::info("✅ Order #{$order->order_id} marked as paid");

    return response()->json(['success' => true]);

}
}
