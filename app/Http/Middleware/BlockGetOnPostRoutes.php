<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockGetOnPostRoutes
{
    public function handle(Request $request, Closure $next)
    {
        $blockedRoutes = [
            'checkout',
            // Add other POST-only routes here
        ];

        if ($request->is($blockedRoutes) && $request->method() === 'GET') {
            abort(405, 'Method Not Allowed');
        }

        return $next($request);
    }
}

