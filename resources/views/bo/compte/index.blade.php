@extends('layouts.admin')

@section('content')

<h1>👤 Mon espace</h1>

<h2>❤️ Mes favoris</h2>
<div class="grid">
@foreach($favoris as $f)
    <div class="card">
        <img src="{{ asset('images/'.$f->livre->couverture) }}">
        <p>{{ $f->livre->titre }}</p>
    </div>
@endforeach
</div>

<h2>📖 Emprunts en cours</h2>
@foreach($enCours as $e)
    <div class="card">
        {{ $e->livre->titre }} — depuis {{ $e->date_emprunt }}
    </div>
@endforeach

<h2>⏳ À retourner</h2>
@foreach($aRetourner as $e)
    <div class="card" style="background:#fee2e2;">
        ⚠️ {{ $e->livre->titre }}
    </div>
@endforeach

<h2>✅ Historique</h2>
@foreach($historique as $e)
    <div class="card">
        ✔️ {{ $e->livre->titre }}
    </div>
@endforeach

@endsection
@extends('layouts.admin')

@section('content')

<h1>👤 Mon espace</h1>

<h2>📖 Emprunts en cours</h2>

@foreach($enCours as $e)
<div class="card">

    <p>{{ $e->livre->titre }}</p>

    <button onclick="retourLivre({{ $e->id }}, this)" class="btn-retour">
        🔄 Retourner
    </button>

</div>
@endforeach

@endsection


@section('scripts')

<script>

function retourLivre(id, btn) {

    fetch('/emprunts/' + id + '/retour', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(data => {

        if (data.success) {

            if (data.retard) {
                showToast(data.retard);
            } else {
                showToast("✅ Livre retourné");
            }

            // 🔥 UX : suppression visuelle
            btn.closest('.card').remove();

        } else {
            showToast("❌ Erreur");
        }

    });

}

</script>

@endsection