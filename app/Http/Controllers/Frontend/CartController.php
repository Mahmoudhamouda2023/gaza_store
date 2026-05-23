<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * عرض صفحة السلة
     */
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $cartTotal = $cartItems->sum('total');

        return view('frontend.cart.index', compact('cartItems', 'cartTotal'));
    }

    /**
     * Ajax Add to Cart — من أي صفحة (يستقبل product_id و quantity)
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'nullable|integer|min:1',
        ]);

        $product  = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        $cartItem = Cart::firstOrNew([
            'user_id'    => Auth::id(),
            'product_id' => $product->id,
        ]);

        $cartItem->quantity = $quantity;
        $cartItem->price    = $product->price;
        $cartItem->total    = $cartItem->quantity * $product->price;
        $cartItem->save();

        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'success'    => true,
            'message'    => 'Cart updated!',
            'cart_count' => (int) $cartCount,
        ]);
    }

    /**
     * تحديث الكمية — +/- من صفحة السلة
     */
    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) abort(403);

        $quantity = (int) $request->input('quantity', 1);
        if ($quantity < 1) $quantity = 1;

        $stock = $cart->product->quantity ?? 9999;
        if ($quantity > $stock) {
            return response()->json([
                'success' => false,
                'message' => "Only {$stock} items available in stock.",
            ], 422);
        }

        $cart->update([
            'quantity' => $quantity,
            'price'    => $cart->product->price,
            'total'    => $cart->product->price * $quantity,
        ]);

        $cartCount  = Cart::where('user_id', Auth::id())->sum('quantity');
        $cartTotal  = Cart::where('user_id', Auth::id())->sum('total');
        $itemTotal  = $cart->product->price * $quantity;

        return response()->json([
            'success'    => true,
            'cart_count' => (int) $cartCount,
            'cart_total' => (float) $cartTotal,   // ✅ float مش string
            'item_total' => (float) $itemTotal,   // ✅ مجموع العنصر الواحد
        ]);
    }

    /**
     * حذف عنصر من السلة
     */
    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) abort(403);

        $cart->delete();

        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
        $cartTotal = Cart::where('user_id', Auth::id())->sum('total');

        return response()->json([
            'success'    => true,
            'message'    => 'Item removed.',
            'cart_count' => (int) $cartCount,
            'cart_total' => (float) $cartTotal,   // ✅ float مش string
        ]);
    }
}
