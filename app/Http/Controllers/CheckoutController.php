<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CheckoutController extends Controller
{

    protected function authorizeView($order)
    {
        if (Auth::check() && Auth::id() !== $order->user_id) {
            throw new AuthorizationException('You are not allowed to view this order.');
        }
    }

    public function thanks(Request $request, Order $order = null)
{
    if (!$order) {
        // No order in route → Try to find order by cookie
        $guestOrderUuid = $request->cookie('guest_order_uuid');

        if ($guestOrderUuid) {
            $order = Order::where('uuid', $guestOrderUuid)->first();
        }
    }

    if ($order) {
        $order->load([
            'items.product',
            'items.sizes',
            'items.colors'
        ]);

        $this->authorizeView($order); // Make sure the guest/user can see it
    }

    return Inertia::render('Checkout/Thanks', [
        'order' => $order,
    ]);
}

    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'delivery_address' => 'required|string|max:255',
            'total_price' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.size_id' => 'nullable|exists:sizes,id', // size validation
            'items.*.color_id' => 'nullable|exists:colors,id', // color validation
        ]);

        // Delete cart entries after checkout
        $cartQuery = Cart::query();

        // Delete cart items based on user or guest token
        if (Auth::check()) {
            $cartQuery->where('user_id', Auth::id());
        } else {
            $cartQuery->where('guest_token', session('guest_token', $request->input('guest_token')));
        }

        // Delete the cart items
        $cartQuery->delete();

        // Create the order
        $order = Order::create([
            'user_id' => Auth::id(),
            'guest_token' => Auth::check() ? null : session('guest_token', $request->input('guest_token')), // Or use guest_token if no user is logged in
            'full_name' => $validated['full_name'],
            'phone_number' => $validated['phone_number'],
            'delivery_address' => $validated['delivery_address'],
            'total_price' => $validated['total_price'],
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        // Create order items and store sizes and colors
        foreach ($validated['items'] as $item) {
            // Create the order item
            $orderItem = $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // Store the size if it's provided
            if ($item['size_id']) {
                $orderItem->sizes()->attach($item['size_id'], ['quantity' => $item['quantity']]);
            }

            // Store the color if it's provided
            if ($item['color_id']) {
                $orderItem->colors()->attach($item['color_id'], ['quantity' => $item['quantity']]);
            }
        }

        return redirect()->route('checkout.thanks', ['order' => $order->uuid])
            ->withCookie(cookie('guest_order_uuid', $order->uuid));
        }
}
