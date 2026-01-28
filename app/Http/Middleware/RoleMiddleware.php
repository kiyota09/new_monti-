<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user has the required role
        if (auth()->user()->role !== $role) {
            return $this->redirectToDefaultDashboard();
        }

        return $next($request);
    }

    /**
     * Redirect user to their appropriate dashboard
     */
    public function redirectToDefaultDashboard(): Response
    {
        $user = auth()->user();

        if ($user->role === 'hrm') {
            return $user->position === 'manager'
                ? redirect()->route('hrm.manager.dashboard')
                : redirect()->route('hrm.staff.dashboard');
        } else {
            return $user->position === 'manager'
                ? redirect()->route('scm.manager.dashboard')
                : redirect()->route('scm.staff.dashboard');
        }
    }
    
    
    
}













 