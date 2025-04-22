<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user
        $request->authenticate();

        // Regenerate session to prevent fixation
        $request->session()->regenerate();

        // Get the authenticated user
        $user = Auth::user();

        // Redirect based on user role
        $role = $user->role; // Ensure 'role' exists on the user model

        if ($role === 'admin') {
            return redirect()->intended(RouteServiceProvider::ADMIN);
        } elseif ($role === 'seller') {
            return redirect()->intended('/seller/dashboard');
        } elseif ($role === 'customer') {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // Default fallback redirect
        return redirect()->intended('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
