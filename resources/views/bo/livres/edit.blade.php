<h1>✏️ Modifier</h1>

<form method="POST" action="/bo/livres/update/{{ $livre->id }}" enctype="multipart/form-data">
@csrf

<input name="titre" value="{{ $livre->titre }}"><br>
<input name="auteur" value="{{ $livre->auteur }}"><br>

<textarea name="description">{{ $livre->description }}</textarea><br>

<input type="file" name="image"><br>

<button>Modifier</button>

</form>