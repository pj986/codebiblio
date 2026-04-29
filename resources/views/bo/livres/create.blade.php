@extends('layouts.admin')

@section('content')

<h1 class="page-title">➕ Ajouter un livre</h1>

<form method="POST" action="/bo/livres" enctype="multipart/form-data" class="form-card">
    @csrf

    <!-- TITRE -->
    <div class="form-group">
        <label>Titre</label>
        <input type="text" name="titre" required>
    </div>

    <!-- AUTEUR -->
    <div class="form-group">
        <label>Auteur</label>
        <input type="text" name="auteur" required>
    </div>

    <!-- CATÉGORIE -->
    <div class="form-group">
        <label>Catégorie</label>
        <select name="categorie">
            <option value="roman">Roman</option>
            <option value="informatique">Informatique</option>
            <option value="histoire">Histoire</option>
        </select>
    </div>

    <!-- DESCRIPTION -->
    <div class="form-group">
        <label>Description</label>
        <textarea name="description"></textarea>
    </div>

    <!-- IMAGE -->
    <div class="form-group">
        <label>Couverture</label>
        <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
        
        <!-- PREVIEW -->
        <img id="preview" style="margin-top:10px; width:120px; border-radius:8px; display:none;">
    </div>

    <!-- ERREURS -->
    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- BUTTON -->
    <button type="submit" class="btn-primary">📚 Ajouter le livre</button>

</form>

<!-- SCRIPT PREVIEW -->
<script>
function previewImage(event) {
    const img = document.getElementById('preview');
    img.src = URL.createObjectURL(event.target.files[0]);
    img.style.display = "block";
}
</script>

@endsection