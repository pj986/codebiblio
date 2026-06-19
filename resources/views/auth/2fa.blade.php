<h2>🔐 Vérification 2FA</h2>

@if(session('code'))
    <p>Code (test) : {{ session('code') }}</p>
@endif

<form method="POST" action="/2fa">
    @csrf
    <input type="text" name="code" placeholder="Code reçu" required>
    <button type="submit">Valider</button>
</form>