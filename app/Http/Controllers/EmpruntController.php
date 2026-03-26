<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exemplaire;
use App\Models\Emprunt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\LivreEmprunte;

class EmpruntController extends Controller
{

    // 📖 Emprunter un livre
    public function emprunter($id)
    {
        $exemplaire = Exemplaire::findOrFail($id);

        // Vérifier disponibilité
        if (!$exemplaire->disponible) {
            return redirect()->back()->with('error', 'Ce livre est déjà emprunté.');
        }

        $user = Auth::user();

        // Créer l'emprunt
        $emprunt = Emprunt::create([
            'user_id' => $user->id,
            'exemplaire_id' => $exemplaire->id,
            'date_emprunt' => now(),
            'date_retour' => now()->addDays(30) // délai 30 jours
        ]);

        // Rendre indisponible
        $exemplaire->disponible = false;
        $exemplaire->save();

        // 📧 Envoi email (Mailtrap)
        try {
            Mail::to($user->email)->send(new LivreEmprunte($emprunt));
        } catch (\Exception $e) {
            // évite crash si mail non configuré
        }

        return redirect()->back()->with('success', 'Livre emprunté avec succès.');
    }

    // 🔁 Retourner un livre
    public function retour($id)
    {
        $exemplaire = Exemplaire::findOrFail($id);

        $emprunt = Emprunt::where('exemplaire_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$emprunt) {
            return redirect()->back()->with('error', 'Emprunt introuvable.');
        }

        // ⚠️ Vérifier retard
        $messageRetard = '';

        if ($emprunt->date_retour && now()->gt($emprunt->date_retour)) {
            $jours = now()->diffInDays($emprunt->date_retour);
            $messageRetard = "⚠ Retard de {$jours} jour(s).";
        }

        // Rendre disponible
        $exemplaire->disponible = true;
        $exemplaire->save();

        // Supprimer emprunt
        $emprunt->delete();

        return redirect()->back()->with(
            'success',
            'Livre retourné avec succès. ' . $messageRetard
        );
    }

    // 📱 Emprunt via QR code
    public function scanEmprunt(Request $request)
    {
        $id = $request->id;

        $exemplaire = Exemplaire::find($id);

        if (!$exemplaire || !$exemplaire->disponible) {
            return response()->json([
                'success' => false,
                'message' => 'Livre indisponible'
            ]);
        }

        $emprunt = Emprunt::create([
            'user_id' => Auth::id(),
            'exemplaire_id' => $exemplaire->id,
            'date_emprunt' => now(),
            'date_retour' => now()->addDays(30)
        ]);

        $exemplaire->disponible = false;
        $exemplaire->save();

        return response()->json([
            'success' => true,
            'message' => 'Livre emprunté via QR code'
        ]);
    }

}