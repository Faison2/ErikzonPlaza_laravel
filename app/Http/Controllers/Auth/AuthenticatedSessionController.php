<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use function auth;

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

        if (auth()->user()->isAdminOrSeller()) {
            return redirect()->intended('/admin/dashboard');
        } elseif (auth()->user()->isCustomer()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        return redirect('/');
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

    protected function redirectToDashboard(User $user)
{
    if ($user->hasRole('admin')) {
        return '/admin/dashboard';
    }

    if ($user->hasRole('user')) {
        return '/user/dashboard';
    }

    return '/';
}

}
