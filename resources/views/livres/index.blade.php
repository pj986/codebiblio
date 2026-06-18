@extends('layouts.app')

@section('content')

<h1 class="page-title">📚 Catalogue</h1>

<div class="grid">

    @foreach($livres as $livre)

<div class="card">

    <div class="image-wrapper">
        <img 
            src="{{ asset('images/' . $livre->couverture) }}" 
            alt="{{ $livre->titre }}"
            onerror="this.src='/images/default.png'"
        >
        
        <!-- ✅ DISPONIBILITÉ -->
    @if($livre->exemplaires->where('disponible', true)->count() == 0)
        <span style="color:red;">❌ Indisponible</span>
    @else
        <span style="color:green;">✅ Disponible</span>
    @endif

        <div class="overlay">
            <button onclick="handleEmprunt({{ $livre->id }})" class="btn">
                📖 Emprunter
            </button>
        </div>
    </div>

    <div class="card-content">
        <h3>{{ $livre->titre }}</h3>
        <p>{{ $livre->auteur }}</p>
    </div>
    <p>
📦 {{ $livre->exemplaires->where('disponible', true)->count() }} disponibles
</p>

</div>

@endforeach
</div>

@endsection
@section('scripts')
<script>

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

        if (data.success) {
            showToast("📚 Livre emprunté");

            setTimeout(() => {
                window.location.href = "/mes-emprunts";
            }, 1000);
        } else {
            showToast(data.message);
        }

    })
    .catch(() => {
        showToast("❌ Erreur serveur");
    });
}

</script>
@endsection