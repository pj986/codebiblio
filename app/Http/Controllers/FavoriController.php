<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use Illuminate\Support\Facades\Auth;

class FavoriController extends Controller
{
    public function toggle($livreId)
    {
        $userId = Auth::id();

        // 🔒 sécurité (au cas où)
        if (!$userId) {
            return redirect('/login');
        }

        // 🔎 recherche existant
        $favori = Favori::where('user_id', $userId)
            ->where('livre_id', $livreId)
            ->first();

        if ($favori) {
            // ❌ supprimer favori
            $favori->delete();

            return back()->with('success', 'Retiré des favoris');
        }

        // ➕ ajouter favori
        Favori::create([
            'user_id' => $userId,
            'livre_id' => $livreId
        ]);

        return back()->with('success', 'Ajouté aux favoris');
    }
    public function toggleAjax($livreId)
{
    $userId = auth()->id();

    $favori = Favori::where('user_id', $userId)
        ->where('livre_id', $livreId)
        ->first();

    if ($favori) {
        $favori->delete();
        return response()->json(['status' => 'removed']);
    }

    Favori::create([
        'user_id' => $userId,
        'livre_id' => $livreId
    ]);

    return response()->json(['status' => 'added']);
}
}