<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
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
    public function store(LoginRequest $request)
    {

        $request->authenticate();

        $user = Auth::user();

        if (!in_array($user->user_role, ['admin', 'partner'])) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Non sei autorizzato ad accedere al backend.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->user_role === 'admin') {
            return view('admin.dashboard');
        }

        if ($user->user_role === 'partner') {
            return view('partner.dashboard');
        }
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
