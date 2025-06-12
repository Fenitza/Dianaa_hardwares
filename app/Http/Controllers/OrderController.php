<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


use App\Models\Order;
use App\Models\CartItem;
use App\Models\User;

use App\Models\Product;
use App\Mail\OrderConfirmation;
use App\Mail\BulkOrderMail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        try {
            $user = Auth::user();
            $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();

            if ($cartItems->isEmpty()) {
                return response()->json(['status' => 'error', 'message' => 'Your cart is empty'], 400);
            }

            $totalAmount = $cartItems->sum(fn($item) => $item->price * $item->quantity);
            $billingDetails = json_encode([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country
            ]);

            // Create order entry in database
            $order = Order::create([
                'user_id' => $user->id,
                'order_id' => $request->order_id, // Razorpay Order ID
                'total_amount' => $totalAmount,
                'payment_status' => 'pending',
                'billing_details' => $billingDetails
            ]);

            // Store order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product->ProductID,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price
                ]);
            }

            return response()->json([
                'status' => 'success',
                'order_id' => $order->id,
                'amount' => $totalAmount * 100
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
/**
     * Handle checkout form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function placeOrder(Request $request)
{
    \Log::info('Received order data:', $request->all());

    try {
        // Validate request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'total' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();

        // Eager-load product to avoid null error
        $cartItems = \App\Models\CartItem::where('user_id', $user->id)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Cart is empty'], 400);
        }

        // Calculate total
        $totalAmount = $validatedData['total']; // Use frontend-confirmed total

        // Generate unique order ID
        $uniqueOrderId = strtoupper('ORD-' . dechex(time()) . '-' . dechex($user->id));

        // Create order
        $order = new \App\Models\Order([
            'order_id' => $uniqueOrderId,
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
            'payment_status' => 'pending',
            'billing_details' => json_encode($validatedData),
        ]);
        $order->save();

        // Save order items
        foreach ($cartItems as $item) {
            $order->items()->create([
                'order_id' => $order->order_id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => floatval($item->product->SalePrice ?? 0),
            ]);
        }

        // Store in session (for success page)
        $order = \App\Models\Order::with(['items.product'])->find($order->id);
        session(['order' => $order]);

        // ✅ Return JSON success response
        return response()->json([
            'status' => 'success',
            'message' => 'Order placed successfully.',
            'order_id' => $order->order_id
        ]);

    } catch (\Exception $e) {
        \Log::error("Error in placeOrder: " . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Order placement failed.',
            'error' => $e->getMessage()
        ], 500);
    }
}



    public function showOrders(Request $request)
{
    $search = $request->input('search', '');
    $perPage = $request->input('perPage', 10);

    $orders = Order::join('users', 'orders.user_id', '=', 'users.id')
                   ->leftJoin('order_items', 'orders.order_id', '=', 'order_items.order_id')
                   ->leftJoin('products', 'order_items.product_id', '=', 'products.ProductID')
                   ->select(
                       'orders.order_id',
                       'users.name as user_name',
                       'users.email',
                       DB::raw('GROUP_CONCAT(DISTINCT CONCAT(order_items.quantity, "x", products.name, "<br>", " (SKU: ", products.sku, ")") SEPARATOR "<br><br>" ) as product_details'),
                       DB::raw('CONCAT(
                           JSON_UNQUOTE(JSON_EXTRACT(orders.billing_details, "$.address")), "<br>",
                           JSON_UNQUOTE(JSON_EXTRACT(orders.billing_details, "$.city")), "<br>",
                           JSON_UNQUOTE(JSON_EXTRACT(orders.billing_details, "$.state")), " ",
                           JSON_UNQUOTE(JSON_EXTRACT(orders.billing_details, "$.postal_code"))
                       ) AS shipping_address'),
                       'orders.total_amount',
                       'orders.payment_status',
                       'orders.created_at'
                   )
                   ->where('orders.order_id', 'like', '%' . $search . '%')
                   ->groupBy(
                       'orders.order_id',
                       'users.name',
                       'users.email',
                       'orders.total_amount',
                       'orders.payment_status',
                       'orders.billing_details',
                       'orders.created_at'
                   )
                   ->simplePaginate($perPage);


    return view('includes.admin.orders.index', compact('orders'));
}
public function show($id)
{
    $order = Order::with(['items.product.manufacturer'])
              ->where('order_id', $id)
              ->firstOrFail();
    $billingDetails = json_decode($order->billing_details);

    return view('includes.admin.orders.show', compact('order', 'billingDetails'));
}

public function updateTracking(Request $request, $id)
{
    $request->validate([
        'tracking_id' => 'nullable|string|max:255'
    ]);

    $order = Order::findOrFail($id);
    $order->tracking_id = $request->tracking_id;
    $order->save();

    return redirect()->back()->with('success', 'Tracking ID updated successfully.');
}


public function orderUser(Request $request)
{
    $search = $request->input('search', '');
    $perPage = $request->input('perPage', 10);

    $userId = Auth::id(); // Get the authenticated user's ID

    $orders = Order::join('users', 'orders.user_id', '=', 'users.id')
                   ->leftJoin('order_items', 'orders.order_id', '=', 'order_items.order_id')
                   ->leftJoin('products', 'order_items.product_id', '=', 'products.ProductID')
                   ->select(
                       'orders.order_id',
                       'orders.tracking_id', // ✅ include tracking ID
                       'users.name as user_name',
                       'users.email',
                       DB::raw('GROUP_CONCAT(DISTINCT CONCAT(order_items.quantity, "x", products.name, "<br>", " (SKU: ", products.sku, ")") SEPARATOR "<br><br>" ) as product_details'),
                       DB::raw('CONCAT(
                           JSON_UNQUOTE(JSON_EXTRACT(orders.billing_details, "$.address")), "<br>",
                           JSON_UNQUOTE(JSON_EXTRACT(orders.billing_details, "$.city")), "<br>",
                           JSON_UNQUOTE(JSON_EXTRACT(orders.billing_details, "$.state")), " ",
                           JSON_UNQUOTE(JSON_EXTRACT(orders.billing_details, "$.postal_code"))
                       ) AS shipping_address'),
                       'orders.total_amount',
                       'orders.payment_status',
                       'orders.created_at'
                   )
                   ->where('orders.user_id', $userId)
                   ->where('orders.order_id', 'like', '%' . $search . '%')
                   ->groupBy(
                       'orders.order_id',
                       'orders.tracking_id', // ✅ group by this too
                       'users.name',
                       'users.email',
                       'orders.total_amount',
                       'orders.payment_status',
                       'orders.billing_details',
                       'orders.created_at'
                   )
                   ->simplePaginate($perPage);

    return view('includes.user.orders.index', compact('orders'));
}


public function userShow($order_id)
{
    $user = Auth::user();

    $order = Order::with(['items.product.manufacturer'])
                ->where('user_id', $user->id)
                ->where('order_id', $order_id)
                ->firstOrFail();

    return view('includes.user.orders.show', compact('order'));
}
 
// place bulk order
public function handleBulkOrder(Request $request)
{
    
    Log::info('Received AJAX data:', $request->all());

    if (!$request->has(['productId', 'quantity', 'message'])) {
        return response()->json(['error' => 'Missing necessary data'], 400);
    }

    try {
        $emailData = $request->all();
        Mail::to('fms.cool16@gmail.com')->send(new BulkOrderMail($emailData));
        return response()->json(['message' => 'Your bulk order request has been sent.']);
    } catch (\Exception $e) {
        Log::error('Mail sending error: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to send email, please try again.'], 500);
    }
}


}