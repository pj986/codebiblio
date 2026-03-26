<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>BiblioTek - Catalogue</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body {
    background: linear-gradient(135deg, #eef2ff, #f8fafc);
    font-family: 'Segoe UI', sans-serif;
}

.navbar {
    background: linear-gradient(90deg, #1e293b, #334155);
}

.card {
    border: none;
    border-radius: 20px;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.12);
}

.btn-emprunter {
    background: linear-gradient(135deg, #3b82f6, #6366f1);
    color: white;
    border-radius: 12px;
}

.heart {
    font-size: 22px;
    cursor: pointer;
}

.fade-in {
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from {opacity:0; transform:translateY(10px);}
    to {opacity:1; transform:translateY(0);}
}

</style>

</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark py-3">
    <div class="container d-flex justify-content-between">

        <a class="navbar-brand fw-bold fs-4" href="/">
            📚 BiblioTek
        </a>

        <div>
            @auth
                <span class="text-white me-3 fw-bold">
                    {{ auth()->user()->name }}
                </span>

                <a href="/dashboard" class="btn btn-light btn-sm">
                    Dashboard
                </a>
            @else
                <a href="/login" class="btn btn-light btn-sm">
                    Login
                </a>
            @endauth
        </div>

    </div>
</nav>

<!-- HEADER -->
<div class="container text-center my-5">
    <h1 class="fw-bold display-5">📖 Catalogue</h1>
    <p class="text-muted">Explorez les livres disponibles</p>
</div>

<!-- FILTRES -->
<div class="container mb-4 d-flex justify-content-center gap-2">

<form class="d-flex gap-2">

<input id="search" class="form-control" placeholder="Rechercher...">

<select id="categorie" class="form-select">
<option value="">Catégories</option>

@foreach($categories as $cat)
<option value="{{ $cat }}">{{ $cat }}</option>
@endforeach

</select>

</form>

</div>

<!-- LIVRES -->
<div class="container">
<div class="row g-4" id="livresContainer">

@foreach($livres as $livre)

<div class="col-md-4 fade-in">

<div class="card p-3 h-100">

<h5 class="fw-bold">{{ $livre->titre }}</h5>

<p class="text-muted">{{ $livre->auteur }}</p>

<span class="badge bg-primary mb-2">
{{ $livre->categorie }}
</span>

<p>{{ $livre->description }}</p>

<!-- ❤️ FAVORI -->
@auth
<form method="POST" action="/favori/{{ $livre->id }}">
@csrf
<button style="border:none;background:none;" class="heart">

@if(in_array($livre->id, $favorisIds))
<span style="color:red;">❤️</span>
@else
<span style="color:#ccc;">🤍</span>
@endif

</button>
</form>
@endauth

<!-- 📥 EMPRUNT -->
@auth
<form method="POST" action="/emprunter/{{ $livre->id }}">
@csrf
<button class="btn btn-emprunter w-100 mt-2">
📥 Emprunter
</button>
</form>
@endauth

@guest
<a href="/login" class="btn btn-secondary w-100 mt-2">
Se connecter
</a>
@endguest

</div>

</div>

@endforeach

</div>
</div>

<!-- PAGINATION -->
<div class="container mt-4 d-flex justify-content-center">
{{ $livres->links() }}
</div>

<!-- AJAX SCRIPT -->
<script>

function loadLivres() {

    let search = document.getElementById('search').value;
    let categorie = document.getElementById('categorie').value;

    fetch(`/ajax/livres?search=${search}&categorie=${categorie}`)
        .then(res => res.json())
        .then(data => {

            let container = document.getElementById('livresContainer');
            container.innerHTML = '';

            data.forEach(livre => {

                container.innerHTML += `
                <div class="col-md-4 fade-in">
                    <div class="card p-3 h-100">

                        <h5>${livre.titre}</h5>
                        <p>${livre.auteur}</p>

                        <span class="badge bg-primary mb-2">
                            ${livre.categorie}
                        </span>

                        <p>${livre.description ?? ''}</p>

                        <form method="POST" action="/emprunter/${livre.id}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="btn btn-success w-100 mt-2">
                                Emprunter
                            </button>
                        </form>

                    </div>
                </div>
                `;
            });

        });
}

document.getElementById('search').addEventListener('keyup', loadLivres);
document.getElementById('categorie').addEventListener('change', loadLivres);

</script>
<!-- 🔥 SCRIPT AJAX ICI -->
<script>

    function showSkeleton() {
        let container = document.getElementById('livresContainer');
        container.innerHTML = '';

        for (let i = 0; i < 6; i++) {
            container.innerHTML += `
            <div class="col-md-4">
                <div class="skeleton"></div>
            </div>
            `;
        }
    }

    function loadLivres() {
        showSkeleton();

        let search = document.getElementById('search').value;
        let categorie = document.getElementById('categorie').value;

        fetch(`/ajax/livres?search=${search}&categorie=${categorie}`)
            .then(res => res.json())
            .then(data => {

                let container = document.getElementById('livresContainer');
                container.innerHTML = '';

                data.forEach(livre => {

                    container.innerHTML += `
                    <div class="col-md-4 fade-in">
                        <div class="card p-3 h-100">

                            <h5>${livre.titre}</h5>
                            <p>${livre.auteur}</p>

                            <span class="badge bg-primary mb-2">
                                ${livre.categorie}
                            </span>

                            <p>${livre.description ?? ''}</p>

                            <button class="heart" data-id="${livre.id}" onclick="toggleFavori(this)">
                                🤍
                            </button>

                            <form method="POST" action="/emprunter/${livre.id}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button class="btn btn-success w-100 mt-2">
                                    Emprunter
                                </button>
                            </form>

                        </div>
                    </div>
                    `;
                });

            });
    }

    function toggleFavori(btn) {

        let id = btn.getAttribute('data-id');

        fetch(`/ajax/favori/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {

            if (data.status === 'added') {
                btn.innerHTML = '<span style="color:red;">❤️</span>';
            } else {
                btn.innerHTML = '<span style="color:#ccc;">🤍</span>';
            }

            btn.style.transform = 'scale(1.3)';
            setTimeout(() => {
                btn.style.transform = 'scale(1)';
            }, 200);
        });
    }

    document.getElementById('search').addEventListener('keyup', loadLivres);
    document.getElementById('categorie').addEventListener('change', loadLivres);

</script>

</body>
</html>