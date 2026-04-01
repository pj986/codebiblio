<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion des exemplaires</title>

<style>

body {
    font-family: Arial;
    margin: 0;
    background: #f4f6f9;
    padding: 20px;
}

h1 {
    margin-bottom: 20px;
}

.btn-add {
    display: inline-block;
    margin-bottom: 15px;
    padding: 8px 12px;
    background: #2ecc71;
    color: white;
    border-radius: 5px;
    text-decoration: none;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background: #eee;
}

tr:hover {
    background: #f9f9f9;
}

.badge-dispo {
    color: green;
    font-weight: bold;
}

.badge-indispo {
    color: red;
    font-weight: bold;
}

.btn {
    padding: 5px 8px;
    border-radius: 4px;
    text-decoration: none;
    color: white;
    margin-right: 5px;
}

.edit { background: #3498db; }
.delete { background: #e74c3c; }

</style>

</head>

<body>

<!-- 🔙 Bouton retour -->
<x-back-button />

<h1>📚 Gestion des exemplaires</h1>

<a href="/bo/exemplaire/ajout" class="btn-add">➕ Ajouter un exemplaire</a>

<table>

<tr>
<th>ID</th>
<th>Livre</th>
<th>État</th>
<th>Disponibilité</th>
<th>Actions</th>
</tr>

@foreach($exemplaires as $ex)

<tr>

<td>{{ $ex->id }}</td>

<td>{{ $ex->livre->titre }}</td>

<td>{{ $ex->etat }}</td>

<td>
@if($ex->disponible)
<span class="badge-dispo">Disponible</span>
@else
<span class="badge-indispo">Emprunté</span>
@endif
</td>

<td>

<a href="/bo/exemplaire/modification/{{ $ex->id }}" class="btn edit">
✏️ Modifier
</a>

<form method="POST" action="/bo/exemplaire/suppression/{{ $ex->id }}" style="display:inline">
    @csrf
    <button class="btn delete">🗑 Supprimer</button>
</form>

</td>

</tr>

@endforeach

</table>

</body>
</html>