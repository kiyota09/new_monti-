<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PositionMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $position): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user has the required position
        if (auth()->user()->position !== $position) {
            return app(RoleMiddleware::class)->redirectToDefaultDashboard();
        }

        return $next($request);
    }
}
