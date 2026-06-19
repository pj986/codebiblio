<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // LOGIN PAGE
    public function showLogin()
    {
        return view('auth.login');
    }

    // REGISTER PAGE
    public function showRegister()
    {
        return view('auth.register');
    }

    // REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user' // IMPORTANT
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    // LOGIN
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {

        $user = Auth::user();

        // 🔐 Génération code 2FA
        $code = rand(100000, 999999);

        $user->two_factor_code = $code;
        $user->two_factor_expires_at = now()->addMinutes(5);
        $user->save();

        // Déconnexion temporaire
        Auth::logout();

        // Stock user en session
        session(['2fa:user:id' => $user->id]);

        return redirect('/2fa')->with('code', $code); // temporaire pour test
    }

    return back()->with('error', 'Identifiants invalides');
}

    // LOGOUT
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
    // PAGE 2FA
public function show2FA()
{
    return view('auth.2fa');
}

// VÉRIFICATION CODE
public function verify2FA(Request $request)
{
    $user = User::find(session('2fa:user:id'));

    if (!$user) {
        return redirect('/login');
    }

    if (
        $user->two_factor_code !== $request->code ||
        now()->gt($user->two_factor_expires_at)
    ) {
        return back()->with('error', 'Code invalide ou expiré');
    }

    // reset code
    $user->two_factor_code = null;
    $user->two_factor_expires_at = null;
    $user->save();

    Auth::login($user);

    return redirect('/dashboard');
}
}