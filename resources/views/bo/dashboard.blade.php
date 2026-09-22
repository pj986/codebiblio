@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

@section('content')

{{-- =========================================================
     EN-TÊTE
========================================================= --}}
<div class="dashboard-header">

    <div>
        <span class="dashboard-eyebrow">
            VUE D'ENSEMBLE
        </span>

        <h1>Tableau de bord gestionnaire</h1>

        <p>
            Suivez l'activité de BiblioTEK et gérez votre bibliothèque.
        </p>
    </div>

    <div class="dashboard-date">
        <span>📅</span>

        <div>
            <small>Aujourd'hui</small>
            <strong>
                {{ now()->translatedFormat('d F Y') }}
            </strong>
        </div>
    </div>

</div>


{{-- =========================================================
     ALERTE RETARDS
========================================================= --}}
@if($nbRetards > 0)

    <div class="dashboard-warning">

        <div class="warning-icon">
            !
        </div>

        <div class="warning-content">
            <strong>
                {{ $nbRetards }}
                {{ $nbRetards > 1 ? 'emprunts sont' : 'emprunt est' }}
                actuellement en retard
            </strong>

            <span>
                Consultez la liste ci-dessous pour effectuer le suivi.
            </span>
        </div>

    </div>

@endif


{{-- =========================================================
     KPI
========================================================= --}}
<div class="dashboard-kpi-grid">

    {{-- LIVRES --}}
    <div class="dashboard-kpi-card">

        <div class="kpi-top">

            <div class="kpi-icon blue">
                📚
            </div>

            <span class="kpi-label">
                Livres
            </span>

        </div>

        <div class="kpi-value">
            {{ $livres }}
        </div>

        <div class="kpi-footer">
            <span>Ouvrages enregistrés</span>
        </div>

    </div>


    {{-- UTILISATEURS --}}
    <div class="dashboard-kpi-card">

        <div class="kpi-top">

            <div class="kpi-icon violet">
                👥
            </div>

            <span class="kpi-label">
                Utilisateurs
            </span>

        </div>

        <div class="kpi-value">
            {{ $users }}
        </div>

        <div class="kpi-footer">
            <span>Comptes enregistrés</span>
        </div>

    </div>


    {{-- EMPRUNTS ACTIFS --}}
    <div class="dashboard-kpi-card">

        <div class="kpi-top">

            <div class="kpi-icon green">
                ↔
            </div>

            <span class="kpi-label">
                Emprunts actifs
            </span>

        </div>

        <div class="kpi-value">
            {{ $empruntsActifs }}
        </div>

        <div class="kpi-footer">
            <span>
                {{ $emprunts }} emprunts au total
            </span>
        </div>

    </div>


    {{-- RETARDS --}}
    <div class="dashboard-kpi-card {{ $nbRetards > 0 ? 'danger' : '' }}">

        <div class="kpi-top">

            <div class="kpi-icon red">
                ⚠
            </div>

            <span class="kpi-label">
                Retards
            </span>

        </div>

        <div class="kpi-value">
            {{ $nbRetards }}
        </div>

        <div class="kpi-footer">

            @if($nbRetards > 0)

                <span class="text-danger">
                    Nécessite votre attention
                </span>

            @else

                <span>
                    Aucun retard actuellement
                </span>

            @endif

        </div>

    </div>

</div>


{{-- =========================================================
     DERNIERS EMPRUNTS
========================================================= --}}
<section class="dashboard-panel">

    <div class="panel-header">

        <div>
            <h2>Derniers emprunts</h2>

            <p>
                Les opérations les plus récentes de la bibliothèque.
            </p>
        </div>

        @if(Route::has('admin.emprunts.index'))

            <a
                href="{{ route('admin.emprunts.index') }}"
                class="panel-link"
            >
                Voir tous les emprunts →
            </a>

        @endif

    </div>


    <div class="admin-table-wrapper">

        <table class="dashboard-table">

            <thead>

                <tr>
                    <th>Livre</th>
                    <th>Utilisateur</th>
                    <th>Date du prêt</th>
                    <th>Retour prévu</th>
                    <th>Statut</th>
                </tr>

            </thead>

            <tbody>

                @forelse($derniersEmprunts as $emprunt)

                    @php
                        $estRetourne =
                            !is_null($emprunt->date_retour_effective);

                        $estEnRetard =
                            !$estRetourne &&
                            $emprunt->date_retour_prevue &&
                            \Carbon\Carbon::parse(
                                $emprunt->date_retour_prevue
                            )->isPast();
                    @endphp

                    <tr>

                        {{-- LIVRE --}}
                        <td>

                            <div class="table-book">

                                <div class="table-book-cover">

                                    @if(
                                        $emprunt->livre &&
                                        $emprunt->livre->couverture
                                    )

                                        <img
                                            src="{{ asset(
                                                'images/' .
                                                $emprunt->livre->couverture
                                            ) }}"
                                            alt=""
                                        >

                                    @else

                                        📖

                                    @endif

                                </div>

                                <div>

                                    <strong>
                                        {{ $emprunt->livre->titre ?? 'Livre supprimé' }}
                                    </strong>

                                    <span>
                                        {{ $emprunt->livre->auteur ?? 'Auteur inconnu' }}
                                    </span>

                                </div>

                            </div>

                        </td>


                        {{-- UTILISATEUR --}}
                        <td>

                            <div class="table-user">

                                <span class="table-avatar">
                                    {{ strtoupper(
                                        substr(
                                            $emprunt->user->name ?? '?',
                                            0,
                                            1
                                        )
                                    ) }}
                                </span>

                                <div>

                                    <strong>
                                        {{ $emprunt->user->name ?? 'Utilisateur supprimé' }}
                                    </strong>

                                    <span>
                                        {{ $emprunt->user->email ?? '' }}
                                    </span>

                                </div>

                            </div>

                        </td>


                        {{-- DATE EMPRUNT --}}
                        <td>

                            @if($emprunt->date_emprunt)

                                {{ \Carbon\Carbon::parse(
                                    $emprunt->date_emprunt
                                )->format('d/m/Y') }}

                            @else

                                —

                            @endif

                        </td>


                        {{-- DATE RETOUR --}}
                        <td>

                            @if($emprunt->date_retour_prevue)

                                {{ \Carbon\Carbon::parse(
                                    $emprunt->date_retour_prevue
                                )->format('d/m/Y') }}

                            @else

                                —

                            @endif

                        </td>


                        {{-- STATUT --}}
                        <td>

                            @if($estRetourne)

                                <span class="status-badge returned">
                                    <span></span>
                                    Retourné
                                </span>

                            @elseif($estEnRetard)

                                <span class="status-badge late">
                                    <span></span>
                                    En retard
                                </span>

                            @else

                                <span class="status-badge active">
                                    <span></span>
                                    En cours
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="empty-table"
                        >
                            <div>📚</div>

                            <strong>
                                Aucun emprunt
                            </strong>

                            <span>
                                Les nouveaux emprunts apparaîtront ici.
                            </span>
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</section>


{{-- =========================================================
     STATISTIQUES
========================================================= --}}
<div class="dashboard-two-columns">

    {{-- GRAPHIQUE --}}
    <section class="dashboard-panel">

        <div class="panel-header">

            <div>
                <h2>Activité des emprunts</h2>

                <p>
                    Évolution sur les 7 derniers jours.
                </p>
            </div>

            <span class="chart-period">
                7 jours
            </span>

        </div>

        <div class="dashboard-chart-container">

            <canvas id="lineChart"></canvas>

        </div>

    </section>


    {{-- TOP LIVRES --}}
    <section class="dashboard-panel">

        <div class="panel-header">

            <div>
                <h2>Livres populaires</h2>

                <p>
                    Les ouvrages les plus empruntés.
                </p>
            </div>

        </div>


        <div class="popular-books">

            @forelse($topLivres as $index => $item)

                <div class="popular-book-item">

                    <span class="popular-position">
                        {{ $index + 1 }}
                    </span>

                    <div class="popular-book-info">

                        <strong>
                            {{ $item->livre->titre ?? 'Livre supprimé' }}
                        </strong>

                        <span>
                            {{ $item->livre->auteur ?? 'Auteur inconnu' }}
                        </span>

                    </div>

                    <span class="popular-count">
                        {{ $item->total }}

                        {{ $item->total > 1
                            ? 'emprunts'
                            : 'emprunt' }}
                    </span>

                </div>

            @empty

                <div class="panel-empty">
                    Aucun emprunt enregistré.
                </div>

            @endforelse

        </div>

    </section>

</div>


{{-- =========================================================
     CATÉGORIES + RETARDS
========================================================= --}}
<div class="dashboard-two-columns">

    {{-- CATÉGORIES --}}
    <section class="dashboard-panel">

        <div class="panel-header">

            <div>
                <h2>Livres par catégorie</h2>

                <p>
                    Répartition de votre catalogue.
                </p>
            </div>

        </div>

        <div class="dashboard-chart-container small">

            <canvas id="booksChart"></canvas>

        </div>

    </section>


    {{-- RETARDS --}}
    <section class="dashboard-panel">

        <div class="panel-header">

            <div>
                <h2>Retards à traiter</h2>

                <p>
                    Emprunts dépassant leur date de retour.
                </p>
            </div>

            @if($nbRetards > 0)

                <span class="late-counter">
                    {{ $nbRetards }}
                </span>

            @endif

        </div>


        <div class="late-list">

            @forelse($retards as $retard)

                <div class="late-item">

                    <div class="late-icon">
                        !
                    </div>

                    <div class="late-information">

                        <strong>
                            {{ $retard->livre->titre ?? 'Livre supprimé' }}
                        </strong>

                        <span>
                            {{ $retard->user->name ?? 'Utilisateur supprimé' }}
                        </span>

                    </div>

                    <div class="late-date">

                        <small>
                            Retour prévu
                        </small>

                        <strong>
                            {{ \Carbon\Carbon::parse(
                                $retard->date_retour_prevue
                            )->format('d/m/Y') }}
                        </strong>

                    </div>

                </div>

            @empty

                <div class="no-late">

                    <span>✓</span>

                    <strong>
                        Tout est à jour
                    </strong>

                    <p>
                        Aucun emprunt en retard actuellement.
                    </p>

                </div>

            @endforelse

        </div>

    </section>

</div>

@endsection


@section('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Vérification Chart.js
    |--------------------------------------------------------------------------
    */

    if (typeof Chart === 'undefined') {

        console.error(
            'Chart.js n’est pas chargé.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | EMPRUNTS - 7 JOURS
    |--------------------------------------------------------------------------
    */

    const lineCanvas =
        document.getElementById('lineChart');

    if (lineCanvas) {

        new Chart(lineCanvas, {

            type: 'line',

            data: {

                labels: @json($labels),

                datasets: [{
                    label: 'Emprunts',

                    data: @json($data),

                    tension: 0.35,

                    fill: true,

                    borderWidth: 2,

                    pointRadius: 3,

                    pointHoverRadius: 5
                }]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    }

                },

                scales: {

                    y: {

                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        },

                        grid: {
                            drawBorder: false
                        }

                    },

                    x: {

                        grid: {
                            display: false
                        }

                    }

                }

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | LIVRES PAR CATÉGORIE
    |--------------------------------------------------------------------------
    */

    const booksCanvas =
        document.getElementById('booksChart');

    if (booksCanvas) {

        new Chart(booksCanvas, {

            type: 'bar',

            data: {

                labels:
                    @json($livresParCategorie->keys()),

                datasets: [{
                    label: 'Livres',

                    data:
                        @json($livresParCategorie->values()),

                    borderWidth: 0,

                    borderRadius: 5
                }]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    }

                },

                scales: {

                    y: {

                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        }

                    },

                    x: {

                        grid: {
                            display: false
                        }

                    }

                }

            }

        });

    }

});
</script>

@endsection