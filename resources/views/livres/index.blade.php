@extends('layouts.app')

@section('content')

<h1 class="page-title">📚 Catalogue</h1>

<div class="grid">

@foreach($livres as $livre)

<div class="card {{ $livre->exemplaires->where('disponible', true)->count() == 0 ? 'unavailable' : '' }}" id="livre-{{ $livre->id }}">

    <div class="image-wrapper">
        <img 
            src="{{ asset('images/' . $livre->couverture) }}" 
            alt="{{ $livre->titre }}"
            onerror="this.src='/images/default.png'"
        >

        <div class="overlay">

            <!-- ✅ BADGE DYNAMIQUE -->
            <span id="badge-{{ $livre->id }}">
                @if($livre->exemplaires->where('disponible', true)->count() == 0)
                    <span class="badge badge-red">❌ Indisponible</span>
                @else
                    <span class="badge badge-green">✅ Disponible</span>
                @endif
            </span>

            <!-- 🎯 BOUTON DYNAMIQUE -->
            @if($livre->exemplaires->where('disponible', true)->count() == 0)

                <button class="btn disabled" disabled title="Aucun exemplaire disponible">
                    ❌ Indisponible
                </button>

            @else

                <button 
                    id="btn-{{ $livre->id }}"
                    onclick="handleEmprunt({{ $livre->id }})" 
                    class="btn"
                >
                    📖 Emprunter
                </button>

            @endif

        </div>
    </div>

    <div class="card-content">
        <button 
    id="fav-{{ $livre->id }}"
    onclick="toggleFavori({{ $livre->id }})"
    class="btn-fav"
>
    🤍
</button>
        <h3>{{ $livre->titre }}</h3>
        <p>{{ $livre->auteur }}</p>
    </div>

    <!-- 📦 STOCK -->
    <p id="stock-{{ $livre->id }}">
        📦 {{ $livre->exemplaires->where('disponible', true)->count() }} disponibles
    </p>

</div>

@endforeach
</div>

@endsection

@section('scripts')
<script>
function toggleFavori(id) {

    const isLogged = {{ auth()->check() ? 'true' : 'false' }};

    if (!isLogged) {
        showToast("⚡ Connecte-toi pour ajouter aux favoris");

        setTimeout(() => {
            window.location.href = "/login";
        }, 1200);

        return;
    }

    fetch('/favori/' + id, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {

        if (data.success) {

            showToast(data.message);

            updateFavoriUI(id, data.favori);

        } else {
            showToast(data.message);
        }

    })
    .catch(() => {
        showToast("❌ Erreur serveur");
    });
}

function updateFavoriUI(id, isFavori) {

    const btn = document.getElementById("fav-" + id);

    if (isFavori) {
        btn.innerHTML = "💖";
        btn.classList.add("active");
    } else {
        btn.innerHTML = "🤍";
        btn.classList.remove("active");
    }

}

function handleEmprunt(id) {

    const isLogged = {{ auth()->check() ? 'true' : 'false' }};

    if (!isLogged) {
        showToast("⚡ Connecte-toi pour emprunter");

        setTimeout(() => {
            window.location.href = "/login";
        }, 1200);

        return;
    }

    emprunter(id);
}

function emprunter(id) {

    fetch('/emprunts/' + id + '/emprunter', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {

    showToast(data.message);

    if (data.success) {

        updateLivreUI(id, data.stock);

    } else {
        showToast(data.message);
    }

})
    .catch(() => {
        showToast("❌ Erreur serveur");
    });
}

function updateLivreUI(id, stockValue) {

    const badge = document.getElementById("badge-" + id);
    const btn = document.getElementById("btn-" + id);
    const stock = document.getElementById("stock-" + id);
    const card = document.getElementById("livre-" + id);

    // 📦 UPDATE STOCK
    stock.innerHTML = `📦 ${stockValue} disponibles`;
    if (stockValue == 1) {
    stock.innerHTML = "⚠️ Dernier exemplaire !";
}

    // 🎨 COULEUR DYNAMIQUE
    if (stockValue <= 2 && stockValue > 0) {
        stock.style.color = "orange"; // ⚠️ stock faible
    } else if (stockValue == 0) {
        stock.style.color = "red"; // ❌ rupture
    } else {
        stock.style.color = "green"; // ✅ OK
    }

    // 🔴 BADGE
    if (stockValue == 0) {
        badge.innerHTML = `<span class="badge badge-red">❌ Indisponible</span>`;
        card.classList.add("unavailable");
    } else {
        badge.innerHTML = `<span class="badge badge-green">✅ Disponible</span>`;
    }

    // 🔒 BOUTON
    if (stockValue == 0 && btn) {
        btn.innerHTML = "❌ Indisponible";
        btn.disabled = true;
        btn.classList.add("disabled");
    }

}

</script>
@endsection