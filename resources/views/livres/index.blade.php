@extends('layouts.app')

@section('content')

<h1 class="page-title">📚 Catalogue</h1>

<div id="livresContainer" class="books-grid">
    @foreach($livres as $livre)

        <div class="book-card">

            <img 
                src="{{ asset('images/' . $livre->couverture) }}" 
                alt="{{ $livre->titre }}"
                class="book-image"
            >

            <h3 class="book-title">{{ $livre->titre }}</h3>
            <p class="book-author">{{ $livre->auteur }}</p>

            <button onclick="handleEmprunt({{ $livre->id }})" class="btn-emprunter">
                📖 Emprunter
            </button>

        </div>

    @endforeach
</div>

@endsection

@section('scripts')

<script>
function handleEmprunt(id) {
    const isLogged = {{ auth()->check() ? 'true' : 'false' }};

    if (!isLogged) {
        showToast("⚠️ Connecte-toi pour emprunter");

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
        if (data.success) {
            showToast(data.message ?? "📚 Livre emprunté avec succès");

            setTimeout(() => {
                window.location.href = "/mes-emprunts";
            }, 1000);
        } else {
            showToast(data.message ?? "❌ Impossible d’emprunter ce livre");
        }
    })
    .catch(() => {
        showToast("❌ Erreur serveur");
    });
}

function showToast(message) {
    const toast = document.getElementById('toast');

    if (!toast) {
        alert(message);
        return;
    }

    toast.innerText = message;
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
    }, 2500);
}
</script>

@endsection