<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EnsureGuestToken
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->cookies->has('guest_token')) {
            return abort(403, 'Missing guest token');
        }

        return $next($request);
    }
}
