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
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'country' => 'required|string|max:255',
        ]);
        \Log::info('Validation passed', $validatedData);

        // Assuming user authentication is handled
        $user = Auth::user();

        // Fetch user's cart items
        $cartItems = CartItem::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Your cart is empty'], 400);
        }

        // Calculate the total amount
        $totalAmount = $cartItems->sum(function($cartItem) {
            return $cartItem->quantity * $cartItem->product->SalePrice;
        });

        // Generate a unique order ID
        $uniqueOrderId = strtoupper('ORD-' . dechex(time()) . '-' . dechex($user->id));

        // Create the order
        $order = new Order([
            'order_id' => $uniqueOrderId, // Use the custom order ID here
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
            'billing_details' => json_encode($validatedData),
        ]);
        $order->save();  // Save the order to generate an ID
        \Log::info('Order created with custom ID: ' . $uniqueOrderId);

        // Attach items to the order
        foreach ($cartItems as $cartItem) {
            $order->items()->create([
                'order_id' => $order->order_id,  // Make sure this matches the column name in your table
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->SalePrice,
            ]);
        }

        // Optionally, clear the cart after order placement
        // $cartItems->each->delete();

        // Store order in session and redirect to success page
        $order = Order::with(['items.product'])->find($order->id);
        if($order) {
            session(['order' => $order]);
        } else {
            \Log::error('Order not found after creation, ID: ' . $order->id);
            return response()->json(['status' => 'error', 'message' => 'Order not found after creation'], 404);
        }
        // Mail::to($user->email)->send(new OrderConfirmation($order));

        return redirect()->route('checkout.success');

    } catch (\Exception $e) {
        \Log::error("Error processing order: " . $e->getMessage());
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}


    public function updatePaymentStatus(Request $request)
    {
        $order = Order::where('order_id', $request->order_id)->first();
        if ($order) {
            $order->update([
                'payment_status' => 'paid',
                'transaction_id' => $request->transaction_id
            ]);

            // Clear cart after payment
            CartItem::where('user_id', Auth::id())->delete();

            return response()->json(['status' => 'success', 'message' => 'Order confirmed!']);
        }
        return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
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
                       'orders.payment_status'
                   )
                   ->where('orders.order_id', 'like', '%' . $search . '%') // Search functionality
                   ->groupBy('orders.order_id', 'users.name', 'users.email', 'orders.total_amount', 'orders.payment_status', 'orders.billing_details')
                   ->simplePaginate($perPage);

    return view('includes.admin.orders', compact('orders'));
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
                       'orders.payment_status'
                   )
                   ->where('orders.user_id', '=', $userId) // Filter orders by user ID
                   ->where('orders.order_id', 'like', '%' . $search . '%') // Search functionality
                   ->groupBy('orders.order_id', 'users.name', 'users.email', 'orders.total_amount', 'orders.payment_status', 'orders.billing_details')
                   ->simplePaginate($perPage);

    return view('includes.user.orders', compact('orders'));
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