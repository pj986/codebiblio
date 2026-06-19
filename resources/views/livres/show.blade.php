@extends('layouts.app')

@section('content')

<div class="hero-book">

    <div class="hero-left">
        <img src="{{ asset('images/' . $livre->couverture) }}" class="hero-img">
    </div>

    <div class="hero-right">

        <h1 class="title">{{ $livre->titre }}</h1>

        <p class="author">✍️ {{ $livre->auteur }}</p>

        <span class="badge">{{ $livre->categorie }}</span>

        <p class="description">
            {{ $livre->description ?? "Aucune description disponible." }}
        </p>

        <div class="actions">

            <button class="btn-emprunter" onclick="handleEmprunt({{ $livre->id }})">
                📖 Emprunter
            </button>

            <button class="btn-secondary">
                ❤️ Favori
            </button>

        </div>

    </div>

</div>

@endsection