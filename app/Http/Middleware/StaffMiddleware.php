<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array($request->user()?->role, ['staff', 'admin'], true)) {

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Staff access only.',
                ], 403);
            }

            return redirect(RouteServiceProvider::HOME)
                ->with('error', 'Staff access only.');
        }

        return $next($request);
    }
}
