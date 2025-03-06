<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\CartItem;
use App\Models\User;

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

    public function placeOrder(Request $request)
    {
        \Log::info('Received order data:', $request->all());
        try {
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
                return $cartItem->quantity * $cartItem->product->SalePrice;  // Ensure that `product` relation is loaded if not eager loaded
            });
   
//           // Generate order_id explicitly
//         $orderId = time()  . $user->id;
//          // Ensure the order_id is being generated and logged before saving the order.
// \Log::info("Generated Order ID: " . $orderId);

        // Process and save the order
        $order = new Order([
            
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
            'billing_details' => json_encode($validatedData),
          
            
        ]);
        $order->save();
        // Check if order ID is saved and log it
\Log::info("Saved Order with ID: " . $order->id);
    
            // Optionally, store each cart item as an order item
            foreach ($cartItems as $cartItem) {
                $order->items()->create([
                    'OrderID' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->SalePrice,  // Assuming price is stored in the product
                ]);
            }
    
            // //Clear the cart if needed
            // $cartItems->each->delete();
    
             // Redirect to the checkout success view with order data
        return redirect()->route('checkout.success')->with('order', $order);
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
}
