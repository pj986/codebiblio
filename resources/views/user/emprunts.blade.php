@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="title">📊 Mon Dashboard</h1>

    <!-- 📊 STATS -->
    <div class="stats" style="display:flex; gap:20px; margin-bottom:30px; justify-content:center;">
        <div class="stat-card" style="padding:15px; background:#fff; border-radius:10px; text-align:center; box-shadow:0 3px 10px rgba(0,0,0,0.05);">
            <h3>{{ $total }}</h3>
            <p>Total</p>
        </div>

        <div class="stat-card" style="padding:15px; background:#fff; border-radius:10px; text-align:center; box-shadow:0 3px 10px rgba(0,0,0,0.05);">
            <h3>{{ $enCours }}</h3>
            <p>En cours</p>
        </div>

        <div class="stat-card" style="padding:15px; background:#fff; border-radius:10px; text-align:center; box-shadow:0 3px 10px rgba(0,0,0,0.05);">
            <h3>{{ $retournes }}</h3>
            <p>Retournés</p>
        </div>
    </div>

    <!-- 🔎 FILTRE -->
    <div id="filters" style="display:flex; justify-content:center; gap:10px; margin-bottom:20px;">
        <input type="text" id="search" placeholder="Rechercher un livre..." style="padding:8px; border-radius:5px; border:1px solid #ccc;">
        <select id="categorie" style="padding:8px; border-radius:5px; border:1px solid #ccc;">
            <option value="all">Toutes catégories</option>
            @foreach($categories as $c)
                <option value="{{ $c }}">{{ ucwords($c) }}</option>
            @endforeach
        </select>
    </div>

    <!-- 📚 LISTE DES EMPRUNTS -->
    <div id="livresContainer" style="display:flex; flex-wrap:wrap; gap:20px; justify-content:center;">

        @foreach($emprunts as $emprunt)
            <div class="card" style="width:200px; padding:15px; background:white; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.05);">

                <!-- IMAGE -->
               @if(optional($emprunt->exemplaire)->livre)
    <img src="{{ asset('images/' . (optional($emprunt->exemplaire->livre)->couverture ?? 'default.png')) }}" 
         alt="livre"
         style="width:100%; height:250px; object-fit:cover; border-radius:5px;">
@else
                    <div style="width:100%; height:250px; background:#eee; display:flex; align-items:center; justify-content:center; color:#999;">
                        ⚠️ Livre supprimé
                    </div>
                @endif

                <!-- TITRE + AUTEUR -->
                @if($emprunt->exemplaire && $emprunt->exemplaire->livre)
                    <h3>{{ $emprunt->exemplaire->livre->titre }}</h3>
                    <p>{{ $emprunt->exemplaire->livre->auteur }}</p>
                    <span class="categorie" style="display:none;">
                    {{ $emprunt->exemplaire->livre->categorie }}
                    </span>
                @endif

                <!-- DATES -->
                <p class="date">📅 {{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</p>

                <!-- 🔴 RETARD -->
                @if(!$emprunt->date_retour_effective && $emprunt->date_retour_prevue && now()->gt($emprunt->date_retour_prevue))
                    <span class="badge late" style="background:#e74c3c; color:white; padding:4px 6px; border-radius:5px;">⚠️ En retard</span>
                @endif

                <!-- 🔄 STATUS -->
                @if($emprunt->date_retour_effective)
                    <span class="badge returned" style="background:#2ecc71; color:white; padding:4px 6px; border-radius:5px;">✅ Rendu</span>
                @else
                    <span class="badge ongoing" style="background:#f1c40f; color:white; padding:4px 6px; border-radius:5px;">⏳ En cours</span>
                @endif
                @if(!$emprunt->date_retour_effective)
    <button onclick="retourner({{ $emprunt->id }})" class="btn" style="margin-top:10px;">
        🔄 Retourner
    </button>
@endif

@if(!$emprunt->date_retour_effective && $emprunt->date_retour_prevue && now()->gt($emprunt->date_retour_prevue))
    <span class="badge late">
        ⚠️ En retard ({{ now()->diffInDays($emprunt->date_retour_prevue) }} jours)
    </span>
@endif

            </div>
        @endforeach

    </div>

</div>

<!-- 🔥 FILTRE DYNAMIQUE -->
<script>
function loadEmprunts() {

    const search = document.getElementById('search').value;
    const categorie = document.getElementById('categorie').value;

    fetch(`/ajax/emprunts?search=${search}&categorie=${categorie}`)
        .then(res => res.json())
        .then(data => {

            let container = document.getElementById('livresContainer');
            container.innerHTML = '';

            if (data.length === 0) {
                container.innerHTML = "<p>Aucun emprunt trouvé</p>";
                return;
            }

            data.forEach(e => {

                let livre = e.exemplaire?.livre;
                if (!livre) return;

                let statut = e.date_retour_effective
                    ? '<span style="color:green;">✅ Rendu</span>'
                    : '<span style="color:orange;">⏳ En cours</span>';

                let retard = (!e.date_retour_effective && e.date_retour_prevue && new Date() > new Date(e.date_retour_prevue))
                    ? '<span style="color:red;">⚠️ En retard</span>'
                    : '';

                container.innerHTML += `
    <div class="card" style="width:200px; padding:15px; background:white; border-radius:10px;">
        
        <img src="/images/${livre.couverture}" 
             style="width:100%; height:250px; object-fit:cover; border-radius:5px;">

        <h3>${livre.titre}</h3>
        <p>${livre.auteur}</p>

        <p>📅 ${e.date_emprunt.substring(0,10)}</p>

        ${statut}
        ${retard}

        ${
            !e.date_retour_effective 
            ? `<button onclick="retourner(${e.id})" class="btn" style="margin-top:10px;">
                    🔄 Retourner
               </button>`
            : ''
        }

    </div>
`;
            });

        });
}

// 🔥 EVENTS
document.getElementById('search').addEventListener('input', loadEmprunts);
document.getElementById('categorie').addEventListener('change', loadEmprunts);
</script>
@section('scripts')
<script>

function retourner(id) {
    fetch('/emprunts/' + id + '/retour', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {

       if (data.success) {

    let message = "📚 Livre retourné";

    if (data.retard) {
        message += "<br>" + data.retard;
    }

    showToast(message);

    setTimeout(() => {
        location.reload();
    }, 1000);
}

    })
    .catch(() => {
        showToast("❌ Erreur serveur");
    });
}

</script>
@endsection
@endsection