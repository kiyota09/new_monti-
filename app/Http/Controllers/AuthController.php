<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:hrm,scm',
            'terms' => 'required|accepted',
            'newsletter' => 'nullable|boolean',
        ]);

        try {
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'position' => 'staff',
                'newsletter_opt_in' => $request->boolean('newsletter', false),
            ]);

            Auth::login($user);

            return $this->redirectBasedOnRole($user);

        } catch (\Exception $e) {
            Log::error('Registration failed: '.$e->getMessage());

            return back()->withErrors([
                'error' => 'Registration failed. Please try again.',
            ])->withInput();
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Redirect user based on role and position
     */
    private function redirectBasedOnRole(User $user)
    {
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
