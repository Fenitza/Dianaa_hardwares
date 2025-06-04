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

    // ✅ match using razorpay_order_id
    $order = \App\Models\Order::where('razorpay_order_id', $request->razorpay_order_id)
        ->with('items.product')
        ->first();

    if (!$order) {
        \Log::error("❌ No order matched Razorpay Order ID: {$request->razorpay_order_id}");
        return response()->json(['success' => false]);
    }

    // ✅ update transaction
    $order->transaction_id = $request->razorpay_payment_id;
    $order->payment_status = 'paid';
    $order->save();

    session(['order' => $order]);

    \Log::info("✅ Order {$order->order_id} marked as paid");

    return response()->json(['success' => true]);
}
}
