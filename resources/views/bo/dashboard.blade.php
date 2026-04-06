@extends('layouts.admin')

@section('content')

<h1>📊 Dashboard Administrateur</h1>

<!-- 🔴 ALERT RETARDS -->
@if($nbRetards > 0)
<div style="background:#ff4d4d; color:white; padding:10px; border-radius:8px; margin-bottom:20px;">
    ⚠️ {{ $nbRetards }} livres en retard !
</div>
@endif

<!-- KPI -->
<div class="cards">
    <div class="card"><h2>{{ $users }}</h2><p>Utilisateurs</p></div>
    <div class="card"><h2>{{ $livres }}</h2><p>Livres</p></div>
    <div class="card"><h2>{{ $emprunts }}</h2><p>Emprunts</p></div>
</div>

<!-- GRAPHS -->
<div class="grid-2">

    <div class="chart-card">
        <h3>📈 Emprunts (7 jours)</h3>
        <canvas id="lineChart"></canvas>
    </div>

    <div class="chart-card">
        <h3>📊 Répartition</h3>
        <canvas id="pieChart"></canvas>
    </div>

</div>

<!-- 📚 LIVRES PAR CATÉGORIE -->
<div class="chart-card">
    <h3>📚 Livres par catégorie</h3>
    <canvas id="booksChart"></canvas>
</div>

<!-- 🏆 TOP LIVRES -->
<div class="card">
    <h3>🏆 Top livres</h3>
    <ul>
        @foreach($topLivres as $t)
            <li>{{ $t->livre->titre }} ({{ $t->total }})</li>
        @endforeach
    </ul>
</div>

<!-- 🔴 LISTE RETARDS -->
@if($nbRetards > 0)
<div class="card">
    <h3>⚠️ Livres en retard</h3>

    @foreach($retards as $r)
        <p>
            📕 {{ $r->livre->titre }} —
            👤 {{ $r->user->name }} —
            ⏰ {{ \Carbon\Carbon::parse($r->date_retour_prevue)->diffForHumans() }}
        </p>
    @endforeach
</div>
@endif

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

// 📈 LINE
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Emprunts',
            data: @json($data),
            tension: 0.4
        }]
    }
});

// 🥧 PIE
new Chart(document.getElementById('pieChart'), {
    type: 'doughnut',
    data: {
        labels: ['En cours', 'Retournés', 'En retard'],
        datasets: [{
            data: [{{ $enCours }}, {{ $retournes }}, {{ $enRetard }}]
        }]
    }
});

// 📚 BAR LIVRES
new Chart(document.getElementById('booksChart'), {
    type: 'bar',
    data: {
        labels: @json(array_keys($livresParCategorie->toArray())),
        datasets: [{
            label: 'Nombre de livres',
            data: @json(array_values($livresParCategorie->toArray()))
        }]
    }
});

</script>

@endsection