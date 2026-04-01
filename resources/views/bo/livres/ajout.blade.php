<h1>➕ Ajouter un livre</h1>

<form method="POST" action="/bo/livres/store" enctype="multipart/form-data">
@csrf

<input name="titre" placeholder="Titre"><br>
<input name="auteur" placeholder="Auteur"><br>

<select name="categorie">
<option>informatique</option>
<option>roman</option>
<option>histoire</option>
</select><br>

<textarea name="description"></textarea><br>

<input type="file" name="image"><br>

<button>Ajouter</button>

</form>