@extends('layouts.app')

@section('content')

<h1>📚 Catalogue</h1>

<div id="livresContainer" style="display:flex; flex-wrap:wrap; gap:20px;">

    @foreach($livres as $livre)
        <div class="card" style="width:200px; padding:15px; background:white; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1);">

            <!-- IMAGE -->
            <img 
                src="{{ asset('images/' . $livre->couverture) }}" 
                style="width:100%; height:250px; object-fit:cover;"
            >

            <!-- INFOS -->
            <h3>{{ $livre->titre }}</h3>
            <p>{{ $livre->auteur }}</p>

            <!-- BOUTON -->
            <button onclick="emprunter({{ $livre->id }})">
                📖 Emprunter
            </button>

        </div>
    @endforeach

</div>

@endsection

@section('scripts')
<script>

// 🔥 EMPRUNT
function emprunter(id) {

    fetch('/emprunts/' + id + '/emprunter', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(data => {
        alert("✅ Livre emprunté !");
    })
    .catch(err => {
        console.error(err);
        alert("❌ Erreur");
    });

}

</script>
@endsection