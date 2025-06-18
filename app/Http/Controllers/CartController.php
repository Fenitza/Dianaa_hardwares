<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Display the cart with its items
    public function index()
    {
        $cartItems = CartItem::with('product')
                              ->where('user_id', Auth::id())
                              ->get();
                              $total = $cartItems->sum(function ($item) {
                                return $item->selected_price * $item->quantity;
                            });

        return view('cart.index', compact('cartItems', 'total'));
    }

    // Add a product to the cart
    public function addToCart(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,ProductID',
        'quantity' => 'required|integer|min:1',
        'selected_color' => 'nullable|string',
        'selected_price' => 'required|numeric|min:0',
    ]);

    $userId = auth()->id(); // or $request->user()->id

    // Check if same item with color already exists
    $existingItem = CartItem::where('user_id', $userId)
        ->where('product_id', $request->product_id)
        ->where('selected_color', $request->selected_color)
        ->first();

    if ($existingItem) {
        // Update quantity if already exists
        $existingItem->quantity += $request->quantity;
        $existingItem->save();
    } else {
        // Create new cart item
        CartItem::create([
            'user_id' => $userId,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'selected_color' => $request->selected_color,
            'selected_price' => $request->selected_price,
        ]);
    }

    return response()->json(['message' => 'Product added to cart successfully']);
}



    public function updateItem(Request $request, $itemId)
    {
        $cartItem = CartItem::where('user_id', Auth::id())->where('id', $itemId)->first();
        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Item not found']);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json(['success' => true, 'message' => 'Cart item updated successfully']);
    }

    public function removeItem($itemId)
    {
        $result = CartItem::where('user_id', Auth::id())->where('id', $itemId)->delete();
        return response()->json(['success' => $result, 'message' => $result ? 'Item removed' : 'Item not found']);
    }

    public function emptyCart()
    {
        $result = CartItem::where('user_id', Auth::id())->delete();
        return response()->json(['success' => $result, 'message' => 'Cart emptied successfully']);
    }

    public function count()
{
    try {
        $userId = Auth::id();
        if (!$userId) {
            session(['cartCount' => 0]);
            return response()->json(['cartCount' => 0]);
        }

        $count = CartItem::where('user_id', $userId)->sum('quantity');
        session(['cartCount' => $count]);
        return response()->json(['cartCount' => $count]);
    } catch (\Exception $e) {
        \Log::error('Failed to count cart items: ' . $e->getMessage());
        return response()->json(['cartCount' => 0]);
    }
}

}
