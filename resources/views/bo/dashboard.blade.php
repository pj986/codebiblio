@extends('layouts.admin')

@section('content')

<h1>📊 Dashboard Administrateur</h1>

<div class="container">

    <!-- CARTES -->
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

</div>

@endsection


@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('chart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Utilisateurs', 'Livres', 'Emprunts'],
        datasets: [{
            label: 'Statistiques',
            data: [{{ $users }}, {{ $livres }}, {{ $emprunts }}],
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>

@endsection