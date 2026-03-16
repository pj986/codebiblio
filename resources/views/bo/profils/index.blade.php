<h1>Back-Office Utilisateurs</h1>

<hr>

@if(session('success'))
<p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">

<tr>
<th>ID</th>
<th>Nom</th>
<th>Email</th>
<th>Nombre d'emprunts</th>
<th>Compte bloqué</th>
<th>Actions</th>
</tr>

@foreach($users as $user)

<tr>

<td>{{ $user->id }}</td>

<td>{{ $user->name }}</td>

<td>{{ $user->email }}</td>

<td>{{ $user->emprunts_count }}</td>

<td>
@if($user->is_blocked)
<span style="color:red">Oui</span>
@else
<span style="color:green">Non</span>
@endif
</td>

<td>

<a href="/bo/profils/{{ $user->id }}">Voir profil</a>

<form method="POST" action="/bo/profils/{{ $user->id }}" style="display:inline">
@csrf
@method('DELETE')
<button>Supprimer</button>
</form>

@if($user->is_blocked)

<form method="POST" action="/bo/profils/{{ $user->id }}/unblock" style="display:inline">
@csrf
<button style="background:green;color:white">
Débloquer le compte
</button>
</form>

@endif

</td>

</tr>

@endforeach

</table>

<br>

<a href="/">Retour au catalogue</a>