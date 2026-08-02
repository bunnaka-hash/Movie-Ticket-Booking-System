<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->role !== 'admin') {

            // API clients keep the JSON contract; browsers are sent back to
            // their own dashboard instead of a raw JSON body on screen.
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Admin access only.',
                ], 403);
            }

            return redirect(RouteServiceProvider::HOME)
                ->with('error', 'Admin access only.');
        }

        return $next($request);
    }
}
