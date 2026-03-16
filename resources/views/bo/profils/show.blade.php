<h1>Détail utilisateur</h1>

<hr>

<h2>{{ $user->name }}</h2>

<p>Email : {{ $user->email }}</p>

<p>Total emprunts : {{ $user->emprunts->count() }}</p>

<hr>

<h3>Historique des emprunts</h3>

@if($user->emprunts->count() == 0)

<p>Aucun emprunt enregistré pour cet utilisateur.</p>

@endif

@foreach($user->emprunts as $emprunt)

<div style="margin-bottom:20px;border:1px solid #ccc;padding:10px">

<p><strong>Date emprunt :</strong> {{ $emprunt->date_emprunt }}</p>

<p><strong>Retour prévu :</strong> {{ $emprunt->date_retour_prevue }}</p>

<h4>Livres empruntés :</h4>

<ul>

@foreach($emprunt->exemplaires as $ex)

<li>{{ $ex->livre->titre }}</li>

@endforeach

</ul>

</div>

@endforeach

<br>

<a href="/bo/profils">Retour</a>