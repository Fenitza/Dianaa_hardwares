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
            return response()->json(['status' => 'error', 'message' => 'Product not found'], 404);
        }

        if ($product->Quantity < $request->quantity) {
            return response()->json(['status' => 'error', 'message' => 'Not enough stock available'], 400);
        }

        // Add the product to the cart
        Cart::add([
            'id' => $product->ProductID,
            'name' => $product->Name,
            'quantity' => $request->Quantity,
            'price' => $product->SalePrice,
        ]);

        // Optional: Update the product stock
        $product->decrement('quantity', $request->quantity);

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart',
            'cartCount' => Cart::getTotalQuantity()  // Get total items quantity in the cart
        ]);
    }
}
