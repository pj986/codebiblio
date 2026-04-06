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
        // 📊 KPI
        $users = User::count();
        $livres = Livre::count();
        $emprunts = Emprunt::count();

        // 📈 Emprunts par jour (7 derniers jours)
        $empruntsParJour = Emprunt::selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $labels = $empruntsParJour->pluck('day')->map(fn($d) => Carbon::parse($d)->format('d/m'));
        $data = $empruntsParJour->pluck('total');

        // 🥧 Répartition
        $enCours = Emprunt::whereNull('date_retour')->count();
        $retournes = Emprunt::whereNotNull('date_retour')->count();
        $enRetard = Emprunt::whereNull('date_retour')
            ->where('date_retour_prevue', '<', now())
            ->count();

        // 📚 📊 LIVRES PAR CATÉGORIE
        $livresParCategorie = Livre::selectRaw('categorie, COUNT(*) as total')
            ->groupBy('categorie')
            ->pluck('total', 'categorie');

        // 🏆 Top livres
        $topLivres = Emprunt::selectRaw('livre_id, COUNT(*) as total')
            ->groupBy('livre_id')
            ->orderByDesc('total')
            ->with('livre')
            ->limit(5)
            ->get();

        // 🔴 RETARDS (ALERTE)
        $retards = Emprunt::with(['livre', 'user'])
            ->whereNull('date_retour')
            ->whereNotNull('date_retour_prevue')
            ->where('date_retour_prevue', '<', now())
            ->orderBy('date_retour_prevue')
            ->limit(5)
            ->get();

        $nbRetards = $retards->count();

        return view('bo.dashboard', compact(
            'users',
            'livres',
            'emprunts',
            'labels',
            'data',
            'enCours',
            'retournes',
            'enRetard',
            'livresParCategorie',
            'topLivres',
            'retards',
            'nbRetards'
        ));
    }
}