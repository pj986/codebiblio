<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Administration') - BiblioTEK
    </title>

    {{-- CSS + JS Laravel / Vite --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @stack('styles')
</head>

<body class="admin-body">

<div class="admin-layout">

    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}
    <aside class="admin-sidebar" id="adminSidebar">

        {{-- LOGO --}}
        <div class="admin-brand">

            <a href="{{ route('admin.dashboard') }}">

                <span class="admin-brand-icon">
                    📚
                </span>

                <div class="admin-brand-text">
                    <strong>BiblioTEK</strong>
                    <small>Administration</small>
                </div>

            </a>

        </div>


        {{-- =================================================
             NAVIGATION
        ================================================== --}}
        <nav class="admin-navigation">


            {{-- DASHBOARD --}}
            <div class="admin-menu-section">

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="admin-menu-link
                    {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                >
                    <span class="admin-menu-icon">▦</span>

                    <span>Tableau de bord</span>
                </a>

            </div>


            {{-- GESTION --}}
            <div class="admin-menu-section">

                <span class="admin-menu-title">
                    Gestion
                </span>


                {{-- LIVRES --}}
                @if(Route::has('admin.livres.index'))

                    <a
                        href="{{ route('admin.livres.index') }}"
                        class="admin-menu-link
                        {{ request()->routeIs('admin.livres.*') ? 'active' : '' }}"
                    >
                        <span class="admin-menu-icon">📚</span>

                        <span>Livres</span>
                    </a>

                @endif


                {{-- AUTEURS --}}
                @if(Route::has('admin.auteurs.index'))

                    <a
                        href="{{ route('admin.auteurs.index') }}"
                        class="admin-menu-link
                        {{ request()->routeIs('admin.auteurs.*') ? 'active' : '' }}"
                    >
                        <span class="admin-menu-icon">✍</span>

                        <span>Auteurs</span>
                    </a>

                @endif


                {{-- CATÉGORIES --}}
                @if(Route::has('admin.categories.index'))

                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="admin-menu-link
                        {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                    >
                        <span class="admin-menu-icon">🏷</span>

                        <span>Catégories</span>
                    </a>

                @endif


                {{-- EXEMPLAIRES --}}
                @if(Route::has('admin.exemplaires.index'))

                    <a
                        href="{{ route('admin.exemplaires.index') }}"
                        class="admin-menu-link
                        {{ request()->routeIs('admin.exemplaires.*') ? 'active' : '' }}"
                    >
                        <span class="admin-menu-icon">▤</span>

                        <span>Exemplaires</span>
                    </a>

                @endif


                {{-- EMPRUNTS --}}
                @if(Route::has('admin.emprunts.index'))

                    <a
                        href="{{ route('admin.emprunts.index') }}"
                        class="admin-menu-link
                        {{ request()->routeIs('admin.emprunts.*') ? 'active' : '' }}"
                    >
                        <span class="admin-menu-icon">↔</span>

                        <span>Emprunts / Retours</span>
                    </a>

                @endif


                {{-- RÉSERVATIONS --}}
                @if(Route::has('admin.reservations.index'))

                    <a
                        href="{{ route('admin.reservations.index') }}"
                        class="admin-menu-link
                        {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}"
                    >
                        <span class="admin-menu-icon">◷</span>

                        <span>Réservations</span>
                    </a>

                @endif

            </div>


            {{-- UTILISATEURS --}}
            <div class="admin-menu-section">

                <span class="admin-menu-title">
                    Utilisateurs
                </span>

                <a
                    href="{{ route('admin.users.index') }}"
                    class="admin-menu-link
                    {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                >
                    <span class="admin-menu-icon">♟</span>

                    <span>Utilisateurs</span>
                </a>

            </div>


            {{-- OUTILS --}}
            <div class="admin-menu-section">

                <span class="admin-menu-title">
                    Outils
                </span>


                @if(Route::has('admin.recherche'))

                    <a
                        href="{{ route('admin.recherche') }}"
                        class="admin-menu-link
                        {{ request()->routeIs('admin.recherche') ? 'active' : '' }}"
                    >
                        <span class="admin-menu-icon">⌕</span>

                        <span>Recherche</span>
                    </a>

                @endif


                @if(Route::has('admin.scanner'))

                    <a
                        href="{{ route('admin.scanner') }}"
                        class="admin-menu-link
                        {{ request()->routeIs('admin.scanner') ? 'active' : '' }}"
                    >
                        <span class="admin-menu-icon">▦</span>

                        <span>Scanner QR</span>
                    </a>

                @endif

            </div>


            {{-- SÉCURITÉ --}}
            <div class="admin-menu-section">

                <span class="admin-menu-title">
                    Sécurité
                </span>

                @if(Route::has('admin.security.index'))

                    <a
                        href="{{ route('admin.security.index') }}"
                        class="admin-menu-link
                        {{ request()->routeIs('admin.security.*') ? 'active' : '' }}"
                    >
                        <span class="admin-menu-icon">🛡</span>

                        <span>Journal de sécurité</span>
                    </a>

                @endif

            </div>

        </nav>


        {{-- =================================================
             BAS SIDEBAR
        ================================================== --}}
        <div class="admin-sidebar-footer">

            <a
                href="{{ route('catalogue') }}"
                class="admin-catalog-link"
            >
                <span>←</span>
                Retour au catalogue
            </a>

        </div>

    </aside>


    {{-- =====================================================
         ZONE PRINCIPALE
    ====================================================== --}}
    <div class="admin-main">


        {{-- =================================================
             TOPBAR
        ================================================== --}}
        <header class="admin-topbar">

            <div class="admin-topbar-left">

                <button
                    type="button"
                    class="admin-mobile-menu"
                    id="adminMobileMenu"
                    aria-label="Ouvrir le menu"
                >
                    ☰
                </button>

                <div class="admin-breadcrumb">

                    <span>
                        Administration
                    </span>

                    <strong>
                        @yield('page-title', 'Tableau de bord')
                    </strong>

                </div>

            </div>


            <div class="admin-topbar-right">


                {{-- ADMIN CONNECTÉ --}}
                @auth

                    <div class="admin-user">

                        <div class="admin-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                        <div class="admin-user-details">

                            <strong>
                                {{ auth()->user()->name }}
                            </strong>

                            <span>
                                Administrateur
                            </span>

                        </div>

                    </div>


                    {{-- DÉCONNEXION --}}
                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="admin-logout"
                        >
                            Déconnexion
                        </button>

                    </form>

                @endauth

            </div>

        </header>


        {{-- =================================================
             MESSAGES
        ================================================== --}}
        <div class="admin-flash-container">

            @if(session('success'))

                <div class="admin-alert success">
                    <span>✓</span>

                    {{ session('success') }}
                </div>

            @endif


            @if(session('error'))

                <div class="admin-alert error">
                    <span>!</span>

                    {{ session('error') }}
                </div>

            @endif

        </div>


        {{-- =================================================
             CONTENU DES PAGES
        ================================================== --}}
        <main class="admin-page-content">

            @yield('content')

        </main>

    </div>

</div>


{{-- OVERLAY MOBILE --}}
<div
    class="admin-sidebar-overlay"
    id="adminSidebarOverlay"
></div>


@yield('scripts')
@stack('scripts')


<script>
document.addEventListener('DOMContentLoaded', function () {

    const sidebar =
        document.getElementById('adminSidebar');

    const button =
        document.getElementById('adminMobileMenu');

    const overlay =
        document.getElementById('adminSidebarOverlay');


    function closeSidebar() {

        if (!sidebar || !overlay) {
            return;
        }

        sidebar.classList.remove('open');

        overlay.classList.remove('open');
    }


    if (button && sidebar && overlay) {

        button.addEventListener('click', function () {

            sidebar.classList.toggle('open');

            overlay.classList.toggle('open');

        });


        overlay.addEventListener(
            'click',
            closeSidebar
        );

    }

});
</script>

</body>
</html>