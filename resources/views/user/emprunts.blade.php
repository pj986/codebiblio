<h1 class="title">📊 Mon Dashboard</h1>

<!-- 📊 STATS -->
<div class="stats">

    <div class="stat-card">
        <h3>{{ $total }}</h3>
        <p>Total</p>
    </div>

    <div class="stat-card">
        <h3>{{ $enCours }}</h3>
        <p>En cours</p>
    </div>

    <div class="stat-card">
        <h3>{{ $retournes }}</h3>
        <p>Retournés</p>
    </div>

</div>

<!-- 📚 LISTE -->
<div class="grid-emprunts">

@foreach($emprunts as $e)
    <div class="card-emprunt">

        <!-- 📖 TITRE -->
        @if($e->livre)
            <h3>{{ $e->livre->titre }}</h3>
        @else
            <h3 style="color:red">⚠️ Livre supprimé</h3>
        @endif

        <!-- 📅 DATE -->
        <p class="date">
            📅 {{ \Carbon\Carbon::parse($e->date_emprunt)->format('d/m/Y') }}
        </p>

        <!-- 🔴 RETARD -->
        @if(!$e->date_retour && $e->date_retour_prevue && now()->gt($e->date_retour_prevue))
            <span class="badge late">⚠️ En retard</span>
        @endif

        <!-- 🔄 STATUS -->
        @if($e->date_retour)
            <span class="badge returned">✅ Rendu</span>
        @else
            <span class="badge ongoing">⏳ En cours</span>
        @endif

    </div>
@endforeach

</div>