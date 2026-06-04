<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Emprunt;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 📊 Statistiques
        $total = Emprunt::where('user_id', $userId)->count();

        $enCours = Emprunt::where('user_id', $userId)
            ->whereNull('date_retour_effective')
            ->count();

        $retournes = Emprunt::where('user_id', $userId)
            ->whereNotNull('date_retour_effective')
            ->count();

        $enRetard = Emprunt::where('user_id', $userId)
            ->whereNull('date_retour_effective')
            ->where('date_retour_prevue', '<', now())
            ->count();

        return view('dashboard', compact(
            'total', 'enCours', 'retournes', 'enRetard'
        ));
    }
}