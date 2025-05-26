<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $file = lang_path(App::currentLocale() . ".json");
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                ] : null
            ],
            'pageTitle' => fn() => $request->route()->getName(),
            'error' => session('error'),
            'message' => session('message'),
            'success' => session('success'),
            'cart' => function () use ($request) {
                $guestToken = $request->cookie('guest_token') ?? session('guest_token');

                $cartData = DB::table('carts')
                    ->when(Auth::check(), function ($query) {
                        $query->where('user_id', Auth::id());
                    }, function ($query) use ($guestToken) {
                        $query->where('guest_token', $guestToken);
                    })
                    ->get();

                return [
                    'quantity' => count($cartData) ?? null,
                ];
            },
            'csrf' => csrf_token(),
            'locale' => App::currentLocale(),
            'locales' => config('app.available_locales'),
            'translations' => File::exists($file) ? File::json($file) : []
        ]);
    }
}
