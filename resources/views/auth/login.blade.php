@extends('layouts.app')

@section('content')

<div class="login-wrapper">

    <div class="login-card">

        <h2>🔐 Connexion</h2>
        <p class="subtitle">Bienvenue sur BiblioTEK</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" required>
                    <span onclick="togglePassword()">👁</span>
                </div>
            </div>

            <button class="btn-login">Se connecter</button>

        </form>

    </div>

</div>

@endsection

@section('scripts')
<script>
function togglePassword() {
    const input = document.getElementById("password");
    input.type = input.type === "password" ? "text" : "password";
}
</script>
@endsection