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
            return $item->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    // Add a product to the cart
    public function addToCart(Request $request)
{
    try {
        \Log::info('Received request to add to cart', [
            'product_id' => $request->product_id,
            'selected_price' => $request->selected_price,
            'selected_color' => $request->selected_color
        ]);

        $product = Product::where('ProductID', $request->product_id)->first();

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found'], 404);
        }

        if ($product->Quantity < $request->quantity) {
            return response()->json([
                'status' => 'error',
                'message' => "Requested quantity is not available. Only {$product->Quantity} left in stock."
            ]);
        }

        $price = floatval($request->selected_price);
        $selectedColor = $request->selected_color;

        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->ProductID)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->price = $price;

            $attributes = json_decode($cartItem->attributes, true);
            $attributes['color'] = $selectedColor;
            $cartItem->attributes = json_encode($attributes);

            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $product->ProductID,
                'quantity' => $request->quantity,
                'price' => $price,
                'attributes' => json_encode([
                    'image' => $product->product_image,
                    'manufacturer' => $product->Manufacturer,
                    'sku' => $product->SKU,
                    'color' => $selectedColor
                ])
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Product added to cart']);
    } catch (\Exception $e) {
        \Log::error('Add to cart error', ['message' => $e->getMessage()]);
        return response()->json(['status' => 'error', 'message' => 'Server error'], 500);
    }
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
