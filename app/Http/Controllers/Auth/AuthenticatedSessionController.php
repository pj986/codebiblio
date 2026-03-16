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
    public function store(Request $request)
{
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    // Vérifier si le compte est bloqué
    if ($user && $user->is_blocked) {

        return back()->withErrors([
            'email' => 'Votre compte est bloqué. Contactez un administrateur.'
        ]);

    }

    // Tentative de connexion
    if (!Auth::attempt($request->only('email','password'))) {

        if ($user) {

            $user->login_attempts += 1;

            // Bloquer après 10 tentatives
            if ($user->login_attempts >= 10) {

                $user->is_blocked = true;

            }

            $user->save();

        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.'
        ]);

    }

    // Connexion réussie → reset compteur
    if ($user) {

        $user->login_attempts = 0;
        $user->save();

    }

    $request->session()->regenerate();

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
