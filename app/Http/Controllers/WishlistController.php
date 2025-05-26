<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class WishlistController extends Controller
{
    public function fetch(Request $request)
    {
        $query = Wishlist::with('product.images');

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } elseif ($request->has('guest_token')) {
            $query->where('guest_token', $request->guest_token);
        } else {
            return response()->json([]);
        }

        return response()->json([
            'wishlists' => $query->get(),
        ]);
    }


    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user();
        $guestToken = $request->guest_token ?? session('guest_token');

        if (!session('guest_token')) {
            session(['guest_token' => $request->guest_token]);
        }

        if (!$user && !$guestToken) {
            return redirect(route('products.index'));
        }

        $query = Wishlist::where('product_id', $request->product_id);

        if ($user) {
            $query->where('user_id', $user->id);
        } else {
            $query->where('guest_token', $guestToken);
        }

        $wishlist = $query->first();

        if ($wishlist) {
            $wishlist->delete();
            return redirect()->back();
        } else {
            Wishlist::create([
                'product_id' => $request->product_id,
                'user_id' => $user?->id,
                'guest_token' => $user ? null : $guestToken,
            ]);
            return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        $guestToken = $request->guest_token ?? session('guest_token');

        if (!session('guest_token')) {
            session(['guest_token' => $request->guest_token]);
        }

        if (!$user && !$guestToken) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $query = Wishlist::where('id', $request->item_id);

        if ($user) {
            $query->where('user_id', $user->id);
        } else {
            $query->where('guest_token', $guestToken);
        }

        $wishlist = $query->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['Success'=>'Success', 200]);
        } else {

        return response()->json(['error' => 'Not Found'], 404);
        }
    }
}
