<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Livre;
use App\Models\Emprunt;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | KPI PRINCIPAUX
        |--------------------------------------------------------------------------
        */

        $users = User::count();

        $livres = Livre::count();

        $emprunts = Emprunt::count();

        $empruntsActifs = Emprunt::whereNull('date_retour_effective')
            ->count();

        $retournes = Emprunt::whereNotNull('date_retour_effective')
            ->count();

        $nbRetards = Emprunt::whereNull('date_retour_effective')
            ->whereNotNull('date_retour_prevue')
            ->where('date_retour_prevue', '<', now())
            ->count();


        /*
        |--------------------------------------------------------------------------
        | DERNIERS EMPRUNTS
        |--------------------------------------------------------------------------
        */

        $derniersEmprunts = Emprunt::with([
                'livre',
                'user'
            ])
            ->orderByDesc('date_emprunt')
            ->limit(8)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | EMPRUNTS DES 7 DERNIERS JOURS
        |--------------------------------------------------------------------------
        */

        $empruntsParJour = Emprunt::selectRaw(
                'DATE(date_emprunt) as day, COUNT(*) as total'
            )
            ->where(
                'date_emprunt',
                '>=',
                now()->subDays(6)->startOfDay()
            )
            ->groupBy('day')
            ->orderBy('day')
            ->get();


        /*
         * On génère toujours les 7 jours,
         * même lorsqu'un jour contient 0 emprunt.
         */

        $labels = collect();

        $data = collect();

        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::today()->subDays($i);

            $labels->push(
                $date->format('d/m')
            );

            $total = $empruntsParJour
                ->firstWhere(
                    'day',
                    $date->format('Y-m-d')
                )
                ?->total ?? 0;

            $data->push($total);
        }


        /*
        |--------------------------------------------------------------------------
        | LIVRES PAR CATÉGORIE
        |--------------------------------------------------------------------------
        */

        $livresParCategorie = Livre::selectRaw(
                'categorie, COUNT(*) as total'
            )
            ->whereNotNull('categorie')
            ->groupBy('categorie')
            ->orderByDesc('total')
            ->pluck(
                'total',
                'categorie'
            );


        /*
        |--------------------------------------------------------------------------
        | TOP 5 DES LIVRES
        |--------------------------------------------------------------------------
        */

        $topLivres = Emprunt::selectRaw(
                'livre_id, COUNT(*) as total'
            )
            ->whereNotNull('livre_id')
            ->groupBy('livre_id')
            ->orderByDesc('total')
            ->with('livre')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | EMPRUNTS EN RETARD
        |--------------------------------------------------------------------------
        */

        $retards = Emprunt::with([
                'livre',
                'user'
            ])
            ->whereNull('date_retour_effective')
            ->whereNotNull('date_retour_prevue')
            ->where(
                'date_retour_prevue',
                '<',
                now()
            )
            ->orderBy('date_retour_prevue')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RETOUR VERS LE DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view(
            'bo.dashboard',
            compact(
                'users',
                'livres',
                'emprunts',
                'empruntsActifs',
                'retournes',
                'nbRetards',
                'derniersEmprunts',
                'labels',
                'data',
                'livresParCategorie',
                'topLivres',
                'retards'
            )
        );
    }
}