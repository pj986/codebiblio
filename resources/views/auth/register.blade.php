<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Créer un compte - BiblioTEK</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, .13), transparent 35%),
                linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%);
            min-height: 100vh;
            color: #172033;
        }

        .register-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 35px 20px;
        }

        .register-container {
            width: 100%;
            max-width: 1020px;
            min-height: 650px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 70px rgba(15, 23, 42, .12);
        }

        /* ==============================
           PARTIE GAUCHE
        ============================== */

        .register-brand {
            position: relative;
            overflow: hidden;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #ffffff;
            background:
                radial-gradient(circle at 20% 20%, rgba(96, 165, 250, .30), transparent 35%),
                linear-gradient(145deg, #0f172a, #172554 60%, #1e3a8a);
        }

        .register-brand::after {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
            right: -100px;
            bottom: -100px;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .brand-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.12);
            font-size: 25px;
        }

        .brand-logo span {
            font-size: 24px;
            font-weight: 800;
        }

        .brand-content {
            position: relative;
            z-index: 1;
        }

        .brand-content h1 {
            font-size: 40px;
            line-height: 1.15;
            margin-bottom: 20px;
        }

        .brand-content p {
            color: #cbd5e1;
            font-size: 16px;
            line-height: 1.7;
            max-width: 390px;
        }

        .brand-features {
            position: relative;
            z-index: 1;
            display: flex;
            gap: 18px;
            flex-wrap: wrap;
            color: #cbd5e1;
            font-size: 13px;
        }

        /* ==============================
           FORMULAIRE
        ============================== */

        .register-form-wrapper {
            padding: 55px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 30px;
        }

        .form-header h2 {
            color: #0f172a;
            font-size: 30px;
            margin-bottom: 8px;
        }

        .form-header p {
            color: #64748b;
            font-size: 14px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 7px;
        }

        .form-control {
            width: 100%;
            height: 48px;
            border: 1px solid #dbe1ea;
            border-radius: 10px;
            padding: 0 14px;
            font-size: 14px;
            color: #0f172a;
            background: #ffffff;
            outline: none;
            transition: .2s ease;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .09);
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper .form-control {
            padding-right: 48px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            cursor: pointer;
            font-size: 17px;
            padding: 5px;
        }

        /* Sécurité mot de passe */

        .password-security {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 13px 15px;
            margin-top: 9px;
        }

        .security-title {
            color: #166534;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .password-rules {
            list-style: none;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5px 12px;
        }

        .password-rules li {
            color: #64748b;
            font-size: 11px;
        }

        .password-rules li.valid {
            color: #15803d;
        }

        .password-rules li::before {
            content: "○";
            margin-right: 5px;
        }

        .password-rules li.valid::before {
            content: "✓";
            font-weight: 800;
        }

        .password-match {
            font-size: 11px;
            color: #64748b;
            margin-top: 7px;
        }

        .password-match.valid {
            color: #15803d;
        }

        /* Erreurs */

        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .error-box ul {
            padding-left: 18px;
            margin: 0;
        }

        /* Bouton */

        .btn-register {
            width: 100%;
            border: 0;
            border-radius: 10px;
            padding: 14px 20px;
            background: #1d4ed8;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s ease;
            margin-top: 5px;
        }

        .btn-register:hover {
            background: #1e40af;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, .20);
        }

        .login-link {
            margin-top: 23px;
            text-align: center;
            color: #64748b;
            font-size: 13px;
        }

        .login-link a {
            color: #1d4ed8;
            font-weight: 700;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Responsive */

        @media (max-width: 850px) {
            .register-container {
                max-width: 520px;
                grid-template-columns: 1fr;
            }

            .register-brand {
                padding: 35px;
                min-height: 260px;
            }

            .brand-content h1 {
                font-size: 30px;
            }

            .brand-features {
                display: none;
            }

            .register-form-wrapper {
                padding: 40px 35px;
            }
        }

        @media (max-width: 480px) {
            .register-page {
                padding: 0;
            }

            .register-container {
                border-radius: 0;
                min-height: 100vh;
            }

            .register-brand {
                min-height: 210px;
                padding: 28px 24px;
            }

            .register-form-wrapper {
                padding: 35px 24px;
            }

            .password-rules {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="register-page">

    <div class="register-container">

        {{-- ============================
             PANNEAU GAUCHE
        ============================ --}}
        <section class="register-brand">

            <div class="brand-logo">
                <div class="brand-icon">📚</div>
                <span>BiblioTEK</span>
            </div>

            <div class="brand-content">
                <h1>Votre bibliothèque, partout avec vous.</h1>

                <p>
                    Créez votre compte pour consulter le catalogue,
                    emprunter vos livres, gérer vos réservations
                    et retrouver vos favoris.
                </p>
            </div>

            <div class="brand-features">
                <span>✓ Catalogue</span>
                <span>✓ Emprunts</span>
                <span>✓ Réservations</span>
                <span>✓ Favoris</span>
            </div>

        </section>


        {{-- ============================
             FORMULAIRE
        ============================ --}}
        <section class="register-form-wrapper">

            <div class="form-header">
                <h2>Créer un compte</h2>
                <p>Rejoignez BiblioTEK en quelques secondes.</p>
            </div>


            {{-- ERREURS LARAVEL --}}
            @if ($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- NOM --}}
                <div class="form-group">
                    <label for="name">Nom complet</label>

                    <input
                        id="name"
                        class="form-control"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Ex. Jean Dupont"
                        required
                        autofocus
                        autocomplete="name"
                    >
                </div>


                {{-- EMAIL --}}
                <div class="form-group">
                    <label for="email">Adresse e-mail</label>

                    <input
                        id="email"
                        class="form-control"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nom@exemple.fr"
                        required
                        autocomplete="username"
                    >
                </div>


                {{-- PASSWORD --}}
                <div class="form-group">
                    <label for="password">Mot de passe</label>

                    <div class="password-wrapper">

                        <input
                            id="password"
                            class="form-control"
                            type="password"
                            name="password"
                            placeholder="Créez un mot de passe sécurisé"
                            required
                            autocomplete="new-password"
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword('password', this)"
                            aria-label="Afficher le mot de passe"
                        >
                            👁
                        </button>

                    </div>

                    <div class="password-security">

                        <div class="security-title">
                            🔒 Sécurité renforcée
                        </div>

                        <ul class="password-rules">
                            <li id="rule-length">8 caractères minimum</li>
                            <li id="rule-case">Majuscule et minuscule</li>
                            <li id="rule-number">Au moins un chiffre</li>
                            <li id="rule-special">Caractère spécial</li>
                        </ul>

                    </div>
                </div>


                {{-- CONFIRMATION --}}
                <div class="form-group">

                    <label for="password_confirmation">
                        Confirmer le mot de passe
                    </label>

                    <div class="password-wrapper">

                        <input
                            id="password_confirmation"
                            class="form-control"
                            type="password"
                            name="password_confirmation"
                            placeholder="Saisissez de nouveau le mot de passe"
                            required
                            autocomplete="new-password"
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword('password_confirmation', this)"
                            aria-label="Afficher le mot de passe"
                        >
                            👁
                        </button>

                    </div>

                    <div
                        id="password-match"
                        class="password-match"
                    >
                        ○ Les deux mots de passe doivent correspondre
                    </div>

                </div>


                <button
                    type="submit"
                    class="btn-register"
                >
                    Créer mon compte
                </button>

            </form>


            <div class="login-link">
                Vous avez déjà un compte ?
                <a href="{{ route('login') }}">
                    Se connecter
                </a>
            </div>

        </section>

    </div>

</div>


<script>
    const password = document.getElementById('password');
    const confirmation = document.getElementById('password_confirmation');

    const lengthRule = document.getElementById('rule-length');
    const caseRule = document.getElementById('rule-case');
    const numberRule = document.getElementById('rule-number');
    const specialRule = document.getElementById('rule-special');
    const passwordMatch = document.getElementById('password-match');


    function setRule(element, valid) {
        element.classList.toggle('valid', valid);
    }


    function validatePassword() {

        const value = password.value;

        setRule(
            lengthRule,
            value.length >= 8
        );

        setRule(
            caseRule,
            /[a-z]/.test(value) && /[A-Z]/.test(value)
        );

        setRule(
            numberRule,
            /\d/.test(value)
        );

        setRule(
            specialRule,
            /[^A-Za-z0-9]/.test(value)
        );

        validateConfirmation();
    }


    function validateConfirmation() {

        const valid =
            confirmation.value.length > 0 &&
            password.value === confirmation.value;

        passwordMatch.classList.toggle('valid', valid);

        passwordMatch.textContent = valid
            ? '✓ Les mots de passe correspondent'
            : '○ Les deux mots de passe doivent correspondre';
    }


    function togglePassword(id, button) {

        const input = document.getElementById(id);

        if (input.type === 'password') {
            input.type = 'text';
            button.textContent = '🙈';
            button.setAttribute(
                'aria-label',
                'Masquer le mot de passe'
            );
        } else {
            input.type = 'password';
            button.textContent = '👁';
            button.setAttribute(
                'aria-label',
                'Afficher le mot de passe'
            );
        }
    }


    password.addEventListener('input', validatePassword);
    confirmation.addEventListener('input', validateConfirmation);
</script>

</body>
</html>