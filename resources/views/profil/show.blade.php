<!DOCTYPE html>
<html>
<head>
    <title>Profil utilisateur</title>
</head>

<body>

<h1>Profil utilisateur</h1>

<hr>

<h2>{{ $user->name }}</h2>

<p>Email : {{ $user->email }}</p>

<hr>

<h3>Nombre total d'emprunts :</h3>

<p>{{ $user->emprunts->count() }}</p>

<hr>

<h3>Historique des emprunts</h3>

@if($user->emprunts->count() == 0)

<p>Aucun emprunt enregistré.</p>

@endif


@foreach($user->emprunts as $emprunt)

<div style="margin-bottom:20px;padding:10px;border:1px solid #ccc">

<p>
<strong>Date d'emprunt :</strong>
{{ $emprunt->date_emprunt }}
</p>

<p>
<strong>Date de retour prévue :</strong>
{{ $emprunt->date_retour_prevue }}
</p>

<h4>Livres empruntés :</h4>

<ul>

@foreach($emprunt->exemplaires as $ex)

<li>

{{ $ex->livre->titre }}

</li>

@endforeach

</ul>

</div>

@endforeach


<hr>
@foreach($user->emprunts as $emprunt)
    <div style="margin-bottom:20px;border:1px solid #ccc;padding:10px">
        <p>Date emprunt : {{ $emprunt->date_emprunt }}</p>
        <p>Date retour prévue : {{ $emprunt->date_retour }}</p>
        <ul>
            @foreach($emprunt->exemplaires as $ex)
                <li>{{ $ex->livre->titre }}</li>
            @endforeach
        </ul>
    </div>
@endforeach

<a href="/">Retour au catalogue</a>

</body>

</html>