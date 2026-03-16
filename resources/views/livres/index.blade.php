<!DOCTYPE html>
<html>

<head>
    <title>Catalogue de la bibliothèque</title>
</head>

<body>

<h1>Catalogue de la bibliothèque</h1>

<hr>

@if(auth()->check())

<p>
Connecté en tant que : <strong>{{ auth()->user()->name }}</strong>
</p>

<a href="/profil/{{ auth()->id() }}">Mon profil</a>

|

<a href="/bo/profils">Back-Office utilisateurs</a>

|

<form method="POST" action="/logout" style="display:inline">
@csrf
<button type="submit">Se déconnecter</button>
</form>

@else

<a href="/login">Connexion</a>

|

<a href="/register">Inscription</a>

@endif

<hr>

@foreach($livres as $livre)

<div style="margin-bottom:25px;border:1px solid #ccc;padding:15px">

<h2>{{ $livre->titre }}</h2>

<p><strong>Auteur :</strong> {{ $livre->auteur }}</p>

<p><strong>Catégorie :</strong> {{ $livre->categorie }}</p>

<h4>Exemplaires :</h4>

@foreach($livre->exemplaires as $ex)

@if($ex->disponible)

<form method="POST" action="/emprunter/{{ $ex->id }}">
@csrf
<button type="submit">Emprunter</button>
</form>

@else

<form method="POST" action="/retour/{{ $ex->id }}">
@csrf
<button type="submit">Retourner</button>
</form>

@endif

@endforeach

</div>

@endforeach

</body>

</html>