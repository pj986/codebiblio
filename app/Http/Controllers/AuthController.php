<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompteBloqueMail;
use App\Models\UserIp;
use App\Mail\AlerteIPMail;



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
    $user = User::where('email', $request->email)->first();

// ⛔ Vérifier si bloqué
if ($user && $user->blocked_until && now()->lt($user->blocked_until)) {
    return back()->with('error', '⛔ Compte bloqué temporairement');
}

    if (Auth::attempt($credentials)) {
        

        $user = Auth::user();
        // ✅ Reset sécurité
$user->login_attempts = 0;
$user->blocked_until = null;
$user->save();
$currentIp = request()->ip();

// 🔍 Vérifier IP connue
$known = UserIp::where('user_id', $user->id)
    ->where('ip', $currentIp)
    ->exists();

// ⚠️ NOUVELLE IP
if (!$known) {

    // 🔥 enregistrer IP
    UserIp::create([
        'user_id' => $user->id,
        'ip' => $currentIp
    ]);

    // 📧 envoyer alerte
    Mail::to($user->email)->send(
        new AlerteIPMail($user, $currentIp)
    );
}


        // 🔐 Génération code 2FA
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->two_factor_code = $code;
        $user->two_factor_expires_at = now()->addMinutes(5);
        $user->save();

        // Déconnexion temporaire
        Auth::logout();

        // Stock user en session
        session(['2fa:user:id' => $user->id]);

        return redirect('/2fa')->with('code', $code); // temporaire pour test
    }
    if ($user) {

    $user->login_attempts++;

    if ($user->login_attempts >= 5 && !$user->blocked_until) {

        $user->blocked_until = now()->addMinutes(10);
        $user->login_attempts = 0;

        // 🔥 ENVOI EMAIL UNIQUE
        Mail::to($user->email)->send(new CompteBloqueMail($user));
    }

    $user->save();
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

    // ✅ CONNEXION RÉELLE
    Auth::login($user);

    // 🔥 AJOUT ICI (TRÈS IMPORTANT)
    $user->update([
        'last_login_at' => now()
    ]);

    return redirect('/dashboard');
}
}