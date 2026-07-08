@extends('layouts.app')

@section('content')

<h1>📅 Mes réservations</h1>

@if($reservations->isEmpty())
    <p>Aucune réservation.</p>
@else

<div class="grid">

@foreach($reservations as $r)

<div class="card">

    <h3>{{ $r->livre->titre }}</h3>

    <p>📖 Auteur : {{ $r->livre->auteur }}</p>

    <p>
        📅 Réservé le : 
        {{ \Carbon\Carbon::parse($r->created_at)->format('d/m/Y') }}
    </p>

    <p>
        📌 Statut :
        @if($r->statut == 'en_attente')
            <span style="color:orange;">⏳ En attente</span>
        @elseif($r->statut == 'honoree')
            <span style="color:green;">✅ Disponible</span>
        @else
            <span style="color:red;">❌ Annulée</span>
        @endif
    </p>

</div>

@endforeach

</div>

@endif

@endsection