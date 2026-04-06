@extends('layouts.admin')

@section('content')

<h1>➕ Ajouter un livre</h1>

<form method="POST" action="/bo/livres" enctype="multipart/form-data">
    @csrf

    <input type="text" name="titre" placeholder="Titre" required>
    <input type="text" name="auteur" placeholder="Auteur" required>

    <select name="categorie">
        <option value="roman">Roman</option>
        <option value="informatique">Informatique</option>
        <option value="histoire">Histoire</option>
    </select>

    <textarea name="description" placeholder="Description"></textarea>

    <input type="file" name="image" required>

    <button type="submit">📚 Ajouter</button>

</form>

@endsection