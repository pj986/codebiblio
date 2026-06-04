<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exemplaire;
use App\Models\Emprunt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\LivreEmprunte;
use Illuminate\Support\Facades\DB;

class EmpruntController extends Controller
{

    // 📖 Emprunter un livre
   public function emprunter($id)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $userId = auth()->id();

    DB::beginTransaction();

    try {
        $hasEmprunt = Emprunt::where('user_id', $userId)
            ->whereNull('date_retour_effective')
            ->exists();

        if ($hasEmprunt) {
            DB::rollBack();

            return back()->with('error', '❌ Vous devez rendre votre livre avant d’en emprunter un autre');
        }

        $exemplaire = Exemplaire::where('livre_id', $id)
            ->where('disponible', true)
            ->lockForUpdate()
            ->first();

        if (!$exemplaire) {
            DB::rollBack();

            return back()->with('error', '❌ Aucun exemplaire disponible');
        }

        Emprunt::create([
            'user_id' => $userId,
            'exemplaire_id' => $exemplaire->id,
            'date_emprunt' => now(),
            'date_retour_prevue' => now()->addDays(30),
            'date_retour_effective' => null,
        ]);

        $exemplaire->disponible = false;
        $exemplaire->save();

        DB::commit();

        return redirect()
            ->route('mes.emprunts')
            ->with('success', '✅ Livre emprunté avec succès');

    } catch (\Exception $e) {
        DB::rollBack();

        return back()->with('error', '❌ Erreur serveur lors de l’emprunt');
    }
}
    // 🔁 Retourner un livre
    public function retour($id)
{
    $emprunt = Emprunt::findOrFail($id);

    // 🔒 sécurité
    if ($emprunt->user_id !== auth()->id()) {
        return response()->json(['error' => 'Non autorisé'], 403);
    }

    // ⚠️ gestion retard
    $messageRetard = '';

    if ($emprunt->date_retour_prevue && now()->gt($emprunt->date_retour_prevue)) {
        $jours = now()->diffInDays($emprunt->date_retour_prevue);
        $messageRetard = "⚠ Retard de {$jours} jour(s)";
    }

    // 🔓 rendre exemplaire dispo
    $exemplaire = $emprunt->exemplaire;
    if ($exemplaire) {
        $exemplaire->disponible = true;
        $exemplaire->save();
    }

    // ✅ marquer comme retourné (MEILLEURE PRATIQUE)
    $emprunt->date_retour_effective = now();
    $emprunt->save();

    return response()->json([
        'success' => true,
        'retard' => $messageRetard
    ]);
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
            'date_retour_effective' => now()->addDays(30)
        ]);

        $exemplaire->disponible = false;
        $exemplaire->save();

        return response()->json([
            'success' => true,
            'message' => 'Livre emprunté via QR code'
        ]);
    }
    public function mesEmprunts()
{
    $userId = auth()->id();

    // 🔹 Statistiques
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

    // 🔹 Liste détaillée des emprunts
    $emprunts = Emprunt::with(['exemplaire.livre'])
        ->where('user_id', $userId)
        ->latest()
        ->get();

    // 📂 Liste des catégories pour le filtre
    $categories = \App\Models\Livre::select('categorie')
        ->distinct()
        ->pluck('categorie');

    // 🔹 Retourner la vue avec toutes les données
    return view('user.emprunts', compact(
        'total', 'enCours', 'retournes', 'enRetard', 'emprunts', 'categories'
    ));
}
public function ajax(Request $request)
{
    $query = Emprunt::with(['exemplaire.livre'])
        ->where('user_id', auth()->id());

    // 🔎 Recherche
    if ($request->search) {
        $query->whereHas('exemplaire.livre', function ($q) use ($request) {
            $q->where('titre', 'like', '%' . $request->search . '%');
        });
    }

    // 📂 Catégorie
    if ($request->categorie && $request->categorie !== 'all') {
        $query->whereHas('exemplaire.livre', function ($q) use ($request) {
            $q->where('categorie', $request->categorie);
        });
    }

    return response()->json($query->latest()->get());
}

}