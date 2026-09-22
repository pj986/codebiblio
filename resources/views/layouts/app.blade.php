<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>BiblioTEK</title>

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS GLOBAL -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- JavaScript Vite -->
@vite(['resources/js/app.js'])

</head>

<body>
    @if(session('error'))
    <div class="alert error">
        ⚠️ {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert success">
        ✅ {{ session('success') }}
    </div>
@endif

<header class="main-header">

    <nav class="premium-navbar">

        {{-- LOGO --}}
        <a href="{{ route('catalogue') }}" class="navbar-brand">
            <span class="brand-symbol">📚</span>

            <div>
                <strong>BiblioTEK</strong>
                <small>Bibliothèque</small>
            </div>
        </a>


        {{-- NAVIGATION --}}
        <div class="navbar-navigation" id="navbarNavigation">

            <a
                href="{{ route('catalogue') }}"
                class="navbar-link {{ request()->routeIs('catalogue') ? 'active' : '' }}"
            >
                Catalogue
            </a>


            @auth

                <a
                    href="{{ route('mes.emprunts') }}"
                    class="navbar-link {{ request()->routeIs('mes.emprunts') ? 'active' : '' }}"
                >
                    Mes emprunts
                </a>


                <a
                    href="{{ route('mes.reservations') }}"
                    class="navbar-link {{ request()->routeIs('mes.reservations') ? 'active' : '' }}"
                >
                    Réservations
                </a>


                <a
                    href="{{ route('mes.favoris') }}"
                    class="navbar-link {{ request()->routeIs('mes.favoris') ? 'active' : '' }}"
                >
                    Favoris

                    @if(isset($countFavoris) && $countFavoris > 0)
                        <span class="navbar-counter">
                            {{ $countFavoris }}
                        </span>
                    @endif
                </a>

            @endauth

        </div>


        {{-- PARTIE DROITE --}}
        <div class="navbar-actions">

            @guest

                <a
                    href="{{ route('login') }}"
                    class="navbar-login"
                >
                    Connexion
                </a>

                <a
                    href="{{ route('register') }}"
                    class="navbar-register"
                >
                    Créer un compte
                </a>

            @else

                {{-- ADMIN --}}
                @if(auth()->user()->role === 'admin')

                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="admin-shortcut"
                    >
                        <span>⚙</span>
                        Administration
                    </a>

                @endif


                {{-- UTILISATEUR --}}
                <div class="user-menu">

                    <button
                        type="button"
                        class="user-menu-button"
                        id="userMenuButton"
                    >

                        <span class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>

                        <span class="user-information">
                            <strong>
                                {{ auth()->user()->name }}
                            </strong>

                            <small>
                                {{ auth()->user()->role === 'admin'
                                    ? 'Administrateur'
                                    : 'Membre' }}
                            </small>
                        </span>

                        <span class="menu-arrow">⌄</span>

                    </button>


                    <div
                        class="user-dropdown"
                        id="userDropdown"
                    >

                        <div class="dropdown-header">

                            <strong>
                                {{ auth()->user()->name }}
                            </strong>

                            <span>
                                {{ auth()->user()->email }}
                            </span>

                        </div>


                        <div class="dropdown-separator"></div>


                        <a href="/bo/mes-activites">
                            👤 Mon espace
                        </a>

                        @if(Route::has('security.index'))
                            <a href="{{ route('security.index') }}">
                                🛡️ Sécurité
                            </a>
                        @endif


                        <div class="dropdown-separator"></div>


                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="dropdown-logout"
                            >
                                ↪ Déconnexion
                            </button>

                        </form>

                    </div>

                </div>

            @endguest


            {{-- DARK MODE --}}
            <button
                type="button"
                class="theme-button"
                onclick="toggleDark()"
                title="Changer le thème"
            >
                ☾
            </button>


            {{-- MOBILE --}}
            <button
                type="button"
                class="mobile-menu-button"
                id="mobileMenuButton"
                aria-label="Ouvrir le menu"
            >
                ☰
            </button>

        </div>

    </nav>

</header>

<!-- CONTENU -->
<div class="container">
    @yield('content')
</div>
<div id="toast" class="toast"></div>
<!-- 🔥 JS GLOBAL (TRÈS IMPORTANT) -->
@yield('scripts')

<script>

// 🔥 AUTO DARK MODE
function initDarkMode() {

    const saved = localStorage.getItem("theme");

    if (saved === "dark") {
        document.body.classList.add("dark");
    } else if (saved === "light") {
        document.body.classList.remove("dark");
    } else {
        // AUTO système
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.body.classList.add("dark");
        }
    }
}

// 🔥 TOGGLE
function toggleDark() {
    document.body.classList.toggle("dark");

    if (document.body.classList.contains("dark")) {
        localStorage.setItem("theme", "dark");
    } else {
        localStorage.setItem("theme", "light");
    }
}

initDarkMode();

</script>
<script>
function showToast(message) {
    const toast = document.getElementById('toast');

    toast.innerText = message;
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
    }, 2500);
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const userButton =
        document.getElementById('userMenuButton');

    const dropdown =
        document.getElementById('userDropdown');

    const mobileButton =
        document.getElementById('mobileMenuButton');

    const navigation =
        document.getElementById('navbarNavigation');


    // Menu utilisateur
    if (userButton && dropdown) {

        userButton.addEventListener('click', function (event) {

            event.stopPropagation();

            dropdown.classList.toggle('open');

        });


        document.addEventListener('click', function (event) {

            if (
                !dropdown.contains(event.target) &&
                !userButton.contains(event.target)
            ) {
                dropdown.classList.remove('open');
            }

        });

    }


    // Menu mobile
    if (mobileButton && navigation) {

        mobileButton.addEventListener('click', function () {

            navigation.classList.toggle('open');

        });

    }

});
</script>
</body>
</html>