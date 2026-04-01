@extends('layouts.app')

@section('content')

<div class="header">
    <h1>📚 BiblioTEK</h1>

    <div>
        @auth
            <span>👤 {{ auth()->user()->name }}</span>
        @else
            <a href="/login">Login</a>
            <a href="/register">Inscription</a>
        @endauth
    </div>
</div>

<h2 class="page-title">Catalogue</h2>

<div class="filters">
    <input type="text" id="search" placeholder="🔎 Rechercher...">

    <select id="categorie">
        <option value="">Toutes catégories</option>
        <option value="informatique">Informatique</option>
        <option value="roman">Roman</option>
        <option value="histoire">Histoire</option>
    </select>
</div>

<div id="livresContainer" class="grid">

    @foreach($livres as $livre)
        <div class="card">

            <img src="{{ asset('images/' . $livre->couverture) }}">

            <div class="card-content">

                <span class="badge">{{ $livre->categorie }}</span>

                <h3>{{ $livre->titre }}</h3>
                <p>{{ $livre->auteur }}</p>

                <button class="btn" onclick="emprunter({{ $livre->id }})">
                    📖 Emprunter
                </button>
                <button onclick="handleEmprunt({{ $livre->id }})">
    📖 Emprunter
</button>

            </div>

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
        }, 1500);

        return;
    }

    emprunter(id);
}

</script>
@endsection

