<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Exemplaire;
use App\Models\Emprunt;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // 📅 CRÉER UNE RÉSERVATION
    public function reserver($livreId)
    {
        $userId = auth()->id();

        // 🔒 éviter double réservation
        $exists = Reservation::where('user_id', $userId)
            ->where('livre_id', $livreId)
            ->where('statut', 'en_attente')
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => '⚠️ Déjà réservé'
            ]);
        }

        Reservation::create([
            'user_id' => $userId,
            'livre_id' => $livreId,
            'statut' => 'en_attente'
        ]);

        return response()->json([
            'success' => true,
            'message' => '📅 Livre réservé avec succès'
        ]);
    }

    // 🔄 ATTRIBUER AUTOMATIQUEMENT APRÈS RETOUR
    public function traiterReservation($livreId)
    {
        // 🔍 chercher une réservation en attente
        $reservation = Reservation::where('livre_id', $livreId)
            ->where('statut', 'en_attente')
            ->orderBy('created_at') // FIFO 🔥
            ->first();

        if (!$reservation) {
            return;
        }

        // 🔍 trouver exemplaire dispo
        $exemplaire = Exemplaire::where('livre_id', $livreId)
            ->where('disponible', true)
            ->first();

        if (!$exemplaire) {
            return;
        }

        // 🔒 rendre indisponible
        $exemplaire->update([
            'disponible' => false
        ]);

        // 📖 créer emprunt automatique
        Emprunt::create([
            'user_id' => $reservation->user_id,
            'exemplaire_id' => $exemplaire->id,
            'date_emprunt' => now(),
            'date_retour_prevue' => now()->addDays(30)
        ]);

        // ✅ marquer réservation comme honorée
        $reservation->update([
            'statut' => 'honoree'
        ]);
    }
    public function index()
{
    $reservations = \App\Models\Reservation::with('livre')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('reservations.index', compact('reservations'));
}
}