<h1>Back Office - Gestion des exemplaires</h1>

<a href="/bo/exemplaire/ajout">Ajouter un exemplaire</a>

<table border="1">

<tr>
<th>ID</th>
<th>Livre</th>
<th>Etat</th>
<th>Disponible</th>
<th>Actions</th>
</tr>

@foreach($exemplaires as $ex)

<tr>

<td>{{ $ex->id }}</td>

<td>{{ $ex->livre->titre }}</td>

<td>{{ $ex->etat }}</td>

<td>

@if($ex->disponible)

Disponible

@else

Emprunté

@endif

</td>

<td>

<a href="/bo/exemplaire/modification/{{ $ex->id }}">Modifier</a>

<a href="/bo/exemplaire/suppression/{{ $ex->id }}">Supprimer</a>

</td>

</tr>

@endforeach

</table>