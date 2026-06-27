@extends('layouts.app')

@section('content')

<h1 class="page-title">❤️ Mes Favoris</h1>

<div class="grid">

@forelse($favoris as $favori)

<div class="card" id="fav-{{ $favori->livre->id }}">

    <img 
        src="{{ asset('images/' . $favori->livre->couverture) }}"
        style="width:100%; height:250px; object-fit:cover;"
    >

    <div class="card-content">
        <h3>{{ $favori->livre->titre }}</h3>
        <p>{{ $favori->livre->auteur }}</p>
    </div>

    <!-- ❤️ SUPPRIMER -->
    <button 
        onclick="removeFavori({{ $favori->livre->id }})"
        class="btn-fav active"
    >
        💖 Retirer
    </button>

</div>

@empty

<p>Aucun favori pour le moment 😢</p>

@endforelse

</div>

@endsection


@section('scripts')
<script>

function removeFavori(id) {

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

            showToast("❌ Supprimé des favoris");

            // 🔥 SUPPRIMER VISUELLEMENT
            document.getElementById("fav-" + id).remove();

        }

    });

}

</script>
@endsection