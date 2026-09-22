@extends('layouts.app')

@section('content')

{{-- =====================================
     HERO
===================================== --}}
<section class="catalog-hero">

    <div class="catalog-hero-content">

        <span class="hero-badge">
            📚 Bibliothèque numérique
        </span>

        <h1>
            Découvrez votre
            <span>prochaine lecture.</span>
        </h1>

        <p>
            Explorez notre collection, trouvez le livre qui vous
            correspond et empruntez-le en quelques clics.
        </p>

        <div class="catalog-search">

            <span class="search-icon">⌕</span>

            <input
                type="search"
                id="catalogSearch"
                placeholder="Rechercher par titre ou auteur..."
                autocomplete="off"
            >

            <button type="button" id="searchButton">
                Rechercher
            </button>

        </div>

        <div class="hero-stats">

            <div>
                <strong>{{ $livres->count() }}</strong>
                <span>Livres</span>
            </div>

            <div>
                <strong>
                    {{ $livres->sum(fn($livre) => $livre->exemplaires->count()) }}
                </strong>
                <span>Exemplaires</span>
            </div>

            <div>
                <strong>24/7</strong>
                <span>Catalogue accessible</span>
            </div>

        </div>

    </div>

    <div class="hero-decoration">
        <div class="floating-book book-one">📘</div>
        <div class="floating-book book-two">📗</div>
        <div class="floating-book book-three">📙</div>
    </div>

</section>


{{-- =====================================
     CATALOGUE
===================================== --}}
<section class="catalog-section">

    <div class="catalog-heading">

        <div>
            <span class="section-eyebrow">
                NOTRE COLLECTION
            </span>

            <h2>Explorer le catalogue</h2>

            <p>
                Retrouvez les ouvrages disponibles dans votre bibliothèque.
            </p>
        </div>

        <div class="catalog-sort">

            <label for="sortBooks">Trier par</label>

            <select id="sortBooks">
                <option value="default">Recommandés</option>
                <option value="az">Titre A → Z</option>
                <option value="za">Titre Z → A</option>
            </select>

        </div>

    </div>


    {{-- FILTRES --}}
    <div class="catalog-filters">

        <button
            type="button"
            class="filter-btn active"
            data-category="all"
        >
            Tous
        </button>

        @foreach($livres->pluck('categorie')->filter()->unique() as $categorie)

            <button
                type="button"
                class="filter-btn"
                data-category="{{ Str::lower($categorie) }}"
            >
                {{ $categorie }}
            </button>

        @endforeach

    </div>


    {{-- COMPTEUR --}}
    <div class="catalog-results">

        <span>
            <strong id="resultCount">
                {{ $livres->count() }}
            </strong>
            ouvrages trouvés
        </span>

    </div>


    {{-- LIVRES --}}
    <div class="premium-book-grid" id="booksGrid">

        @foreach($livres as $livre)

            @php
                $stock = $livre->exemplaires
                    ->where('disponible', true)
                    ->count();
            @endphp

            <article
                class="premium-book-card"
                data-title="{{ Str::lower($livre->titre) }}"
                data-author="{{ Str::lower($livre->auteur) }}"
                data-category="{{ Str::lower($livre->categorie ?? '') }}"
            >

                {{-- IMAGE --}}
                <div class="book-cover">

                    @if($livre->couverture)

                        <img
                            src="{{ asset('images/' . $livre->couverture) }}"
                            alt="Couverture de {{ $livre->titre }}"
                            loading="lazy"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >

                        <div class="cover-placeholder">
                            <span>📖</span>
                            <small>{{ $livre->titre }}</small>
                        </div>

                    @else

                        <div
                            class="cover-placeholder"
                            style="display:flex;"
                        >
                            <span>📖</span>
                            <small>{{ $livre->titre }}</small>
                        </div>

                    @endif


                    {{-- FAVORI --}}
                    @auth

                        <button
                            type="button"
                            id="fav-{{ $livre->id }}"
                            class="premium-favorite"
                            onclick="toggleFavori({{ $livre->id }})"
                            title="Ajouter aux favoris"
                        >
                            ♡
                        </button>

                    @endauth


                    {{-- CATÉGORIE --}}
                    <span class="book-category">
                        {{ $livre->categorie ?? 'Livre' }}
                    </span>

                </div>


                {{-- INFORMATIONS --}}
                <div class="book-information">

                    <div class="book-main">

                        <h3>
                            {{ $livre->titre }}
                        </h3>

                        <p class="book-author">
                            {{ $livre->auteur }}
                        </p>

                    </div>


                    {{-- STOCK --}}
                    <div
                        class="book-stock
                        {{ $stock === 0 ? 'out' : ($stock <= 2 ? 'low' : '') }}"
                        id="stock-{{ $livre->id }}"
                    >

                        <span class="stock-dot"></span>

                        @if($stock === 0)

                            Indisponible

                        @elseif($stock === 1)

                            Dernier exemplaire

                        @else

                            {{ $stock }} exemplaires disponibles

                        @endif

                    </div>


                    {{-- ACTION --}}
                    <div class="book-actions">

                        @auth

                            @if($stock > 0)

                                <button
                                    type="button"
                                    id="btn-{{ $livre->id }}"
                                    class="btn-borrow"
                                    onclick="handleEmprunt({{ $livre->id }})"
                                >
                                    Emprunter
                                    <span>→</span>
                                </button>

                            @else

                                <button
                                    type="button"
                                    class="btn-reserve"
                                    onclick="handleReservation({{ $livre->id }})"
                                >
                                    Réserver
                                </button>

                            @endif

                        @else

                            <a
                                href="{{ route('login') }}"
                                class="btn-borrow"
                            >
                                Se connecter pour emprunter
                                <span>→</span>
                            </a>

                        @endauth

                    </div>

                </div>

            </article>

        @endforeach

    </div>


    {{-- AUCUN RÉSULTAT --}}
    <div class="no-books" id="noBooks">

        <div>🔎</div>

        <h3>Aucun livre trouvé</h3>

        <p>
            Essayez une autre recherche ou une autre catégorie.
        </p>

    </div>

</section>
@section('scripts')

<script>
document.addEventListener('DOMContentLoaded', () => {

    const search = document.getElementById('catalogSearch');
    const searchButton = document.getElementById('searchButton');

    const filters = document.querySelectorAll('.filter-btn');

    const grid = document.getElementById('booksGrid');

    const resultCount = document.getElementById('resultCount');

    const noBooks = document.getElementById('noBooks');

    const sort = document.getElementById('sortBooks');

    let selectedCategory = 'all';


    function filterBooks() {

        const query = search.value
            .trim()
            .toLowerCase();

        const books = document.querySelectorAll(
            '.premium-book-card'
        );

        let visible = 0;

        books.forEach(book => {

            const title = book.dataset.title || '';
            const author = book.dataset.author || '';
            const category = book.dataset.category || '';

            const matchesSearch =
                title.includes(query) ||
                author.includes(query);

            const matchesCategory =
                selectedCategory === 'all' ||
                category === selectedCategory;

            const shouldShow =
                matchesSearch && matchesCategory;

            book.style.display =
                shouldShow ? '' : 'none';

            if (shouldShow) {
                visible++;
            }
        });


        resultCount.textContent = visible;

        noBooks.style.display =
            visible === 0 ? 'block' : 'none';
    }


    search.addEventListener(
        'input',
        filterBooks
    );


    searchButton.addEventListener(
        'click',
        filterBooks
    );


    filters.forEach(button => {

        button.addEventListener('click', () => {

            filters.forEach(btn =>
                btn.classList.remove('active')
            );

            button.classList.add('active');

            selectedCategory =
                button.dataset.category;

            filterBooks();
        });

    });


    sort.addEventListener('change', () => {

        const books = Array.from(
            document.querySelectorAll(
                '.premium-book-card'
            )
        );

        if (sort.value === 'az') {

            books.sort((a, b) =>
                a.dataset.title.localeCompare(
                    b.dataset.title,
                    'fr'
                )
            );

        }

        if (sort.value === 'za') {

            books.sort((a, b) =>
                b.dataset.title.localeCompare(
                    a.dataset.title,
                    'fr'
                )
            );

        }

        books.forEach(book =>
            grid.appendChild(book)
        );

    });

});
</script>

@endsection

@endsection