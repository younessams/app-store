<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle user registration.
     */
    private function transferGuestCartToUser($guestToken, $userId)
    {
        Cart::where('guest_token', $guestToken)
            ->update([
                'user_id' => $userId,
                'guest_token' => null,
            ]);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        if (session()->has('guest_token')) {
            $this->transferGuestCartToUser(session('guest_token'), Auth::id());
            session()->forget('guest_token');
        }

        return redirect()->route('home');
    }

    /**
     * Handle user login.
     */
    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        if (session()->has('guest_token')) {
            $this->transferGuestCartToUser(session('guest_token'), Auth::id());
            // session()->forget('guest_token');
        }

        return redirect()->route('home');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');;
    }
}
