<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body {
    font-family: Arial;
    margin: 0;
    background: #f4f6f9;
}

header {
    background: #2c3e50;
    color: white;
    padding: 20px;
}

.container {
    padding: 30px;
}

.cards {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
}

.card {
    flex: 1;
    background: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.card h2 {
    margin: 0;
    font-size: 30px;
}

.card p {
    color: #777;
}

.chart-container {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.nav {
    margin-top: 20px;
}

.nav a {
    margin-right: 15px;
    text-decoration: none;
    color: #3498db;
}

</style>

</head>

<body>

<header>
    <h1>📊 Dashboard Administrateur</h1>
</header>

<div class="container">

    <!-- CARTES STATS -->
    <div class="cards">

        <div class="card">
            <h2>{{ $users }}</h2>
            <p>Utilisateurs</p>
        </div>

        <div class="card">
            <h2>{{ $livres }}</h2>
            <p>Livres</p>
        </div>

        <div class="card">
            <h2>{{ $emprunts }}</h2>
            <p>Emprunts</p>
        </div>

    </div>

    <!-- GRAPH -->
    <div class="chart-container">
        <canvas id="chart"></canvas>
    </div>

    <!-- NAV -->
    <div class="nav">
        <a href="/bo/profils">👥 Utilisateurs</a>
        <a href="/bo/logs">📜 Logs</a>
        <a href="/">🏠 Site</a>
    </div>

</div>

<script>

const ctx = document.getElementById('chart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Utilisateurs', 'Livres', 'Emprunts'],
        datasets: [{
            label: 'Statistiques',
            data: [{{ $users }}, {{ $livres }}, {{ $emprunts }}],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

</script>

</body>
</html>