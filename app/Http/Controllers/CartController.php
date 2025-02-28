<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Cart; // Assuming Cart is a facade or a helper class you're using

class CartController extends Controller
{
    // Display the cart with its items
    public function index()
    {
        $cartItems = Cart::getContent(); // Fetch cart items from a session or DB
        $total = Cart::getTotal();       // Get the total price of items in the cart

        return view('cart.index', ['cartItems' => $cartItems, 'total' => $total]);
    }

    // Add a product to the cart
    public function addToCart(Request $request)
{
    $product = Product::find($request->product_id);
    if (!$product) {
        \Log::error('Product not found', ['product_id' => $request->product_id]);
        return response()->json(['status' => 'error', 'message' => 'Product not found'], 404);
    }

    \Log::info('Product found', ['quantity' => $product->Quantity, 'requested' => $request->quantity]);

    if ($product->Quantity > 0 && $product->Quantity < $request->quantity) {
        \Log::error('Not enough stock', ['stock' => $product->Quantity, 'requested' => $request->quantity]);
        $message = sprintf("We're sorry, but the requested quantity of %s is currently unavailable. We currently have only %d units in stock. Please adjust your order to %d units or fewer to proceed with adding it to your cart.",
            $product->Name,
            $product->Quantity,
            $product->Quantity
        );
        return response()->json(['status' => 'error', 'message' => $message]);
    }
    if ($product->Quantity == 0) {
        \Log::info('Product out of stock', ['product_id' => $product->ProductID]);
        return response()->json(['status' => 'error', 'message' => 'This product is currently out of stock.']);
    }

    // Your add to cart logic here
    
    
        Cart::add([
            'id' => $product->ProductID,
            'name' => $product->Name,
            'quantity' => $request->quantity,
            'price' => $product->SalePrice,
                'attributes' => [
                'image' => $product->product_image, // Ensure attribute names are correctly cased
                'manufacturer' => $product->Manufacturer,
                'sku' => $product->SKU,
            ]
        ]);
        \Log::debug('Adding to cart', [
            'id' => $product->ProductID,
            'name' => $product->Name,
            'quantity' => $request->quantity,
            'price' => $product->SalePrice,
            'attributes' => [
                'image' => $product->Image,
                'manufacturer' => $product->Manufacturer,
                'sku' => $product->SKU,
            ]
        ]);
        
        // Now calculate unique product IDs in the cart
        $uniqueProductIds = Cart::getContent()->unique('id')->count();
    
        return response()->json(['status' => 'success', 'message' => 'Product added to cart', 'cartCount' => $uniqueProductIds]);
}

public function updateQuantity($itemId, Request $request)
    {
        // Assume $cart is an instance of some Cart model or service that handles cart operations
        $newQuantity = $request->input('quantity');

        try {
            $cart->updateItem($itemId, $newQuantity);
            return response()->json(['success' => true, 'message' => 'Cart updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
 
public function updateItem(Request $request, $itemId)
{
    $cartItem = Cart::get($itemId); // Assuming Cart::get() fetches the item by ID
    if (!$cartItem) {
        return response()->json(['success' => false, 'message' => 'Item not found']);
    }

    $quantity = $request->input('quantity', 1); // Default to 1 if no quantity provided
    Cart::update($itemId, [
        'quantity' => [
            'relative' => false,
            'value' => $quantity
        ]
    ]);

    return response()->json(['success' => true, 'message' => 'Quantity updated']);
}

public function removeItem($itemId)
{
    Cart::remove($itemId); // Removes the item from the cart

    return response()->json(['success' => true, 'message' => 'Item removed']);
}


public function emptyCart(Request $request)
{
    // Assuming cart is stored in the session
    session()->forget('cart');
    return response()->json(['success' => true, 'message' => 'Cart emptied successfully.']);
}

public function checkout()
{
    // Here you would handle payment logic
    // After payment confirmation:
    Cart::clear(); // Optionally clear the cart after successful payment

    // Assuming 'checkout.page' is a route that shows a confirmation page
    return redirect()->route('checkout.page');
}

}
