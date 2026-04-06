@extends('layouts.app')

@section('content')

<h1>📚 Catalogue</h1>

<div id="livresContainer" style="display:flex; flex-wrap:wrap; gap:20px;">
    @foreach($livres as $livre)
        <div class="card" style="width:200px; padding:15px; background:white; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1);">

            <!-- IMAGE -->
            <img 
                src="{{ asset('images/' . $livre->couverture) }}" 
                style="width:100%; height:250px; object-fit:cover;">

            <!-- INFOS -->
            <h3>{{ $livre->titre }}</h3>
            <p>{{ $livre->auteur }}</p>

            <!-- BOUTON EMPRUNTER -->
            <button onclick="handleEmprunt({{ $livre->id }})">
                📖 Emprunter
            </button>

        </div>
    @endforeach
</div>

@endsection

@section('scripts')

<script>
// Vérifier si l'utilisateur est connecté et gérer l'emprunt
function handleEmprunt(id) {
    const isLogged = {{ auth()->check() ? 'true' : 'false' }};
    
    if (!isLogged) {
        showToast("⚠️ Connecte-toi pour emprunter");
        setTimeout(() => {
            window.location.href = "/login"; // Redirection vers la page de connexion
        }, 1200);
        return;
    }

    emprunter(id);
}

// Fonction emprunter
function emprunter(id) {
    fetch('/emprunts/' + id + '/emprunter', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast("📚 Livre emprunté avec succès");
        } else {
            showToast("❌ " + data.message);
        }
    })
    .catch(() => {
        showToast("❌ Erreur serveur");
    });
}

// Fonction pour afficher le toast
function showToast(message) {
    const toast = document.getElementById('toast');
    toast.innerText = message;
    toast.classList.add('show');
    setTimeout(() => {
        toast.classList.remove('show');
    }, 2500);
}
</script>

@endsection