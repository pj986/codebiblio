<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Favori;
use App\Models\Emprunt;

class CompteController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // ❤️ FAVORIS
        $favoris = Favori::with('livre')
            ->where('user_id', $userId)
            ->get();

        // 📖 EMPRUNTS EN COURS + BADGES
        $enCours = Emprunt::with('livre')
            ->where('user_id', $userId)
            ->whereNull('date_retour')
            ->get()
            ->map(function ($e) {

                if (!$e->date_retour_prevue) {
                    $e->statut = 'ok';
                    return $e;
                }

                if (now()->gt($e->date_retour_prevue)) {
                    $e->statut = 'retard';
                    $e->jours_retard = now()->diffInDays($e->date_retour_prevue);
                } elseif (now()->addDays(3)->gt($e->date_retour_prevue)) {
                    $e->statut = 'warning';
                } else {
                    $e->statut = 'ok';
                }

                return $e;
            });

        // ✅ HISTORIQUE
        $historique = Emprunt::with('livre')
            ->where('user_id', $userId)
            ->whereNotNull('date_retour')
            ->get();

        return view('bo.compte.index', compact(
            'favoris',
            'enCours',
            'historique'
        ));
    }
}