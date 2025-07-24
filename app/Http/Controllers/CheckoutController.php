<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
{
    $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();

    if ($cartItems->isEmpty()) {
        return redirect('/cart')->with('error', 'Your cart is empty.');
    }

    // Calculate subtotal
    $subtotal = $cartItems->sum(fn($item) => $item->selected_price * $item->quantity);

    // Calculate total net weight
    $netWeight = $cartItems->sum(function ($item) {
        return $item->product->weight * $item->quantity;
    });

    // Initial total (before shipping)
    $total = $subtotal;

    // Fetch user
    $user = Auth::user();

    return view('checkout.index', compact('cartItems', 'subtotal', 'total', 'user', 'netWeight'));
}


    public function updateBillingDetails(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'phone_number' => 'required|int|max:15',
            'billing_address' => 'required|string|max:255',
            'billing_city' => 'required|string|max:255',
            'billing_state' => 'required|string|max:255',
            'billing_postal_code' => 'required|string|max:10',
            'billing_country' => 'required|string|max:255',
        ]);

        // Update user billing details
        $user->update([
            'phone_number' => $request->phone_number,
            'billing_address' => $request->billing_address,
            'billing_city' => $request->billing_city,
            'billing_state' => $request->billing_state,
            'billing_postal_code' => $request->billing_postal_code,
            'billing_country' => $request->billing_country,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Billing details updated successfully']);
    }


   

    public function checkout()
    {
    // Here you would handle payment logic
    // After payment confirmation:
    // Cart::clear(); // Optionally clear the cart after successful payment

    // Assuming 'checkout.page' is a route that shows a confirmation page
    return view('pages.checkout');
    }

    /**
     * Handle checkout form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:10',
            'country' => 'required|string|max:255',
        ]);

        // Process the payment and create the order
        // Assume a service that handles the payment and order creation
        // $order = OrderService::createOrder(Auth::user()->id, $validated);

        // Redirect to the success page if everything is successful
        return redirect()->route('checkout.success');
    }

    /**
     * Display the success page after checkout.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function success()
{
    $order = session('order');
    if ($order) {
        // $order = Order::with('items.product')->find($order->order_id);
        \Log::info('Full Order details:', $order->toArray()); // Safely log order details
        \Log::info('Detailed Order Info:', [
            'id' => $order->order_id,
            // 'user_name' => $order->user->name,  // Ensure user is loaded or exists
            'items' => $order->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
        'product_name' => optional($item->product)->Name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ];
            })->toArray(),
        ]);
    } else {
        \Log::error("Order session is null, could not retrieve order details.");
    }
    $order = Order::with(['items.product'])->find($order->order_id);
    return view('checkout.success', compact('order'));
}

}
