<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Détail utilisateur - {{ $user->name }}</title>

<style>
/* Style de base (inchangé) */
body {
    font-family: Arial, sans-serif;
    background: #f4f6f9;
    padding: 20px;
}

h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

/* CARD PROFIL */
.profile-card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.profile-card h2 {
    margin-top: 0;
}

.badge {
    display: inline-block;
    background: #3498db;
    color: white;
    padding: 4px 8px;
    border-radius: 5px;
}

/* HISTORIQUE */
.emprunt-card {
    background: white;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 10px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}

.emprunt-card ul {
    margin: 5px 0;
}

.emprunt-card li {
    margin-bottom: 3px;
}

/* BOUTON */
.btn-retour {
    display: inline-block;
    margin-top: 20px;
    text-decoration: none;
    background: #3498db;
    color: white;
    padding: 8px 12px;
    border-radius: 5px;
    font-weight: bold;
}

.btn-retour:hover {
    background: #2779bd;
}

</style>

</head>

<body>

<!-- 🔙 Bouton retour moderne -->
<x-back-button />

<h1>👤 Détail utilisateur</h1>

<!-- 👤 INFOS -->
<div class="profile-card">
    <h2>{{ $user->name }}</h2>
    <p><strong>Email :</strong> {{ $user->email }}</p>
    <p><strong>Total emprunts :</strong> <span class="badge">{{ $user->emprunts->count() }}</span></p>
</div>

<hr>

<h3>📚 Historique des emprunts</h3>

<!-- Formulaire de tri -->
<form method="GET" action="{{ url()->current() }}">
    <label for="sortBy">Trier par :</label>
    <select name="sortBy" id="sortBy">
        <option value="date_emprunt" {{ $sortBy == 'date_emprunt' ? 'selected' : '' }}>Date emprunt</option>
        <option value="date_retour_prevue" {{ $sortBy == 'date_retour_prevue' ? 'selected' : '' }}>Date retour prévue</option>
    </select>

    <label for="sortDir">Ordre :</label>
    <select name="sortDir" id="sortDir">
        <option value="asc" {{ $sortDir == 'asc' ? 'selected' : '' }}>Ascendant</option>
        <option value="desc" {{ $sortDir == 'desc' ? 'selected' : '' }}>Descendant</option>
    </select>

    <button type="submit">Appliquer</button>
</form>

@if($user->emprunts->count() == 0)
    <p>Aucun emprunt enregistré pour cet utilisateur.</p>
@endif

@foreach($emprunts as $emprunt)
    <div class="emprunt-card">
        <p><strong>📅 Date emprunt :</strong> {{ $emprunt->date_emprunt }}</p>
        <p><strong>⏳ Retour prévu :</strong> {{ $emprunt->date_retour_prevue }}</p>

        <h4>Livres empruntés :</h4>
        <ul>
            @foreach($emprunt->exemplaires as $exemplaire)
                <li>📖 {{ $exemplaire->livre->titre }}</li>
            @endforeach
        </ul>
    </div>
@endforeach

<br>

<!-- Bouton retour vers la liste des utilisateurs -->
<a href="/bo/profils" class="btn-retour">⬅ Retour à la liste des utilisateurs</a>

</body>
</html>