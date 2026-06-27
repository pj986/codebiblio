<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use Illuminate\Support\Facades\Auth;

class FavoriController extends Controller
{

    // ❤️ VERSION CLASSIQUE (si besoin formulaire)
    public function toggle($livreId)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userId = Auth::id();

        $favori = Favori::where('user_id', $userId)
            ->where('livre_id', $livreId)
            ->first();

        if ($favori) {
            $favori->delete();

            return back()->with('success', '❌ Retiré des favoris');
        }

        Favori::create([
            'user_id' => $userId,
            'livre_id' => $livreId
        ]);

        return back()->with('success', '❤️ Ajouté aux favoris');
    }


    // ⚡ VERSION AJAX (UTILISÉE DANS TON FRONT)
    public function toggleAjax($livreId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => '⚠️ Non connecté'
            ]);
        }

        $userId = Auth::id();

        $favori = Favori::where('user_id', $userId)
            ->where('livre_id', $livreId)
            ->first();

        if ($favori) {

            $favori->delete();

            return response()->json([
                'success' => true,
                'favori' => false,
                'message' => '❌ Retiré des favoris'
            ]);
        }

        Favori::create([
            'user_id' => $userId,
            'livre_id' => $livreId
        ]);

        return response()->json([
            'success' => true,
            'favori' => true,
            'message' => '❤️ Ajouté aux favoris'
        ]);
    }


    // 📄 PAGE MES FAVORIS
    public function index()
    {
        $favoris = Favori::with('livre')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('favoris.index', compact('favoris'));
    }

}