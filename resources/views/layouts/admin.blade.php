<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin BiblioTEK</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<div id="adminLayout" class="admin-container">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="sidebar">

        <button class="toggle-btn" onclick="toggleSidebar()">
            <i class="fa-solid fa-bars"></i>
        </button>
        <a href="/bo/mes-activites" class="menu-item">
        <i class="fa-solid fa-user"></i>
        <span>Mon espace</span>
        </a>

        <h2 class="logo">⚙️ Admin</h2>

        <nav class="menu">

            <a href="/bo/dashboard" class="menu-item">
                <i class="fa-solid fa-chart-line"></i>
                <span>Dashboard</span>
            </a>

            <a href="/bo/profils" class="menu-item">
                <i class="fa-solid fa-users"></i>
                <span>Utilisateurs</span>
            </a>

            <a href="/bo/recherche" class="menu-item">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>Recherche</span>
            </a>

            <a href="/bo/scanner" class="menu-item">
                <i class="fa-solid fa-qrcode"></i>
                <span>QR Code</span>
            </a>

        </nav>

    </aside>

    <!-- CONTENU -->
    <main class="admin-content">
        @yield('content')
    </main>

</div>

@yield('scripts')

</body>
</html>