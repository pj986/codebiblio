<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>BiblioTEK</title>

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link rel="stylesheet" href="/css/style.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>

<h1>📚 BiblioTEK</h1>

<div id="filters">
    <input type="text" id="search" placeholder="Rechercher un livre...">

    <select id="category">
        <option value="">Toutes catégories</option>
        <option value="business">Business</option>
        <option value="roman">Roman</option>
        <option value="science">Science</option>
        <option value="informatique">Informatique</option>
    </select>
</div>

<!-- 📚 CONTENU -->
<div id="livresContainer">

    <!-- 🔥 AFFICHAGE INITIAL (Laravel) -->
    @foreach($livres as $livre)
        <div class="card">
            <img src="{{ $livre->image }}" alt="">
            <h3>{{ $livre->titre }}</h3>
            <p>{{ $livre->auteur }}</p>

            <button onclick="emprunter({{ $livre->id }})">
                📖 Emprunter
            </button>
        </div>
    @endforeach

</div>

<!-- Pagination -->
<div id="pagination">
    {{ $livres->links() }}
</div>

<script>

// Skeleton loader
function showSkeleton() {
    let container = document.getElementById('livresContainer');
    container.innerHTML = '';

    for (let i = 0; i < 6; i++) {
        container.innerHTML += `<div class="skeleton"></div>`;
    }
}

// 🔎 AJAX LOAD
function loadLivres() {

    showSkeleton();

    let search = document.getElementById('search').value;
    let category = document.getElementById('category').value;

    fetch('/ajax/livres?search=' + search + '&category=' + category)
        .then(res => res.json())
        .then(data => {

            let container = document.getElementById('livresContainer');
            container.innerHTML = '';

            data.livres.data.forEach(livre => {
                container.innerHTML += `
                <div class="card">
                    <img src="${livre.image}">
                    <h3>${livre.titre}</h3>
                    <p>${livre.auteur}</p>

                    <button onclick="emprunter(${livre.id})">
                        📖 Emprunter
                    </button>
                </div>
                `;
            });

            document.getElementById('pagination').innerHTML = '';

        })
        .catch(err => {
            console.error("Erreur AJAX :", err);
        });
}

// 📖 EMPRUNT
function emprunter(id) {

    fetch('/emprunts/' + id + '/emprunter', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(() => {
        alert("✅ Livre emprunté !");
    })
    .catch(() => {
        alert("❌ Erreur lors de l'emprunt");
    });
}

// EVENTS
document.getElementById('search').addEventListener('input', loadLivres);
document.getElementById('category').addEventListener('change', loadLivres);

</script>

</body>
</html>