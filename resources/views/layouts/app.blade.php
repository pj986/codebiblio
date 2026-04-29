<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>BiblioTEK</title>

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="/css/style.css">

</head>

<body>

<!-- NAVBAR -->
<nav class="navbar">

    <div class="logo">📚 BiblioTEK</div>

    <div class="nav-links">

        <a href="/">🏠 Catalogue</a>

        @auth

            <span class="user-name">👤 {{ auth()->user()->name }}</span>

            <!-- 📚 Mes emprunts -->
            <a href="{{ route('mes.emprunts') }}">📚 Mes emprunts</a>

            <!-- 👤 Mon espace -->
            <a href="/bo/mes-activites">⚙️ Mon espace</a>

            <!-- 👑 Admin -->
            @if(auth()->user()->role === 'admin')
                <a href="/bo/dashboard">👑 Admin</a>
            @endif

            <!-- 🚪 Logout -->
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button class="btn-logout">🚪 Logout</button>
            </form>

        @else

            <a href="{{ route('login') }}">🔐 Login</a>
            <a href="{{ route('register') }}">📝 Register</a>

        @endauth

        <!-- 🌙 Dark mode -->
        <button onclick="toggleDark()" class="btn-dark">
            🌙
        </button>

    </div>

</nav>

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
<div id="toast" class="toast"></div>
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
</body>
</html>