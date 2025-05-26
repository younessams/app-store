<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $guestToken = Auth::check() ? null : ($request->cookie('guest_token') ?? session('guest_token'));

            $cartItems = Cart::with(['product.images', 'color', 'size', 'product' => function($query) {
                $query->select('id', 'stock', 'name');  // Select the id and stock columns from products
            }])
            ->when(Auth::check(), fn($q) => $q->where('user_id', Auth::id()))
            ->when($guestToken !== null, fn($q) => $q->where('guest_token', $guestToken))
            ->get();

        return inertia('Cart/Index', [
            'cartItems' => $cartItems,
        ]);
    }


    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'quantity' => 'required|integer|min:1',
            'guest_token' => 'required|string',
        ]);

        $user_id = Auth::check() ? Auth::id() : null;
        $guest_token = $validated['guest_token'] ?? session('guest_token');

        // Store guest token in session
        if (!$user_id) {
            session(['guest_token' => $guest_token]);
        }

        $product = Product::findOrFail($validated['product_id']);
        $color = $product->colors()->findOrFail($validated['color_id']);
        $size = $product->sizes()->findOrFail($validated['size_id']);

        if ($validated['quantity'] > $product->stock) {
            return redirect()->back()->with('error', 'Not enough stock available');
        }

        $cart = Cart::where([
            'product_id' => $product->id,
            'user_id' => $user_id,
            'guest_token' => $user_id ? null : $guest_token,
            'size_id' => $size->id,
            'color_id' => $color->id,
        ])->first();

        if ($cart) {
            $cart->quantity += $validated['quantity'];
            $cart->total_price = $product->price * $cart->quantity;
            $cart->save();
        } else {
            Cart::create([
                'product_id' => $product->id,
                'user_id' => $user_id,
                'guest_token' => $user_id ? null : $guest_token,
                'size_id' => $size->id,
                'color_id' => $color->id,
                'quantity' => $validated['quantity'],
                'total_price' => $product->price * $validated['quantity'],
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    public function update(Request $request, Cart $cart)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'guest_token' => 'string',
        ]);

        if ($validated['quantity'] > $cart->product->stock) {
            return redirect()->back('400');
        }

        $cart->update([
            'quantity' => $validated['quantity'],
            'total_price' => $cart->product->price * $validated['quantity'],
        ]);

        return back()->with('success', 'Cart item updated.');
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();

        return back()->with('message', 'Item removed from cart.');
    }
}
