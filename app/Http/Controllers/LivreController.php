<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livre;
use Illuminate\Support\Facades\Auth;

class LivreController extends Controller
{
    // 📚 PAGE CATALOGUE
    public function index(Request $request)
    {
        $query = Livre::query();

        // 🔎 Recherche
        if ($request->search) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }

        // 📂 Filtre catégorie
        if ($request->categorie && $request->categorie !== 'all') {
            $query->where('categorie', $request->categorie);
        }

        // 📄 Pagination
        $livres = $query->latest()->paginate(9)->withQueryString();

        // 📂 Liste des catégories
        $categories = Livre::select('categorie')->distinct()->pluck('categorie');

        // ❤️ Favoris utilisateur
        $favorisIds = [];

        if (Auth::check()) {
            $favorisIds = Auth::user()
                ->favoris()
                ->pluck('livre_id')
                ->toArray();
        }

        return view('livres.index', compact('livres', 'categories', 'favorisIds'));
    }

    // ⚡ AJAX (RECHERCHE DYNAMIQUE)
    public function ajax(Request $request)
    {
        $query = Livre::query();

        // 🔎 Recherche
        if ($request->search) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }

        // 📂 Catégorie
        if ($request->categorie && $request->categorie !== 'all') {
            $query->where('categorie', $request->categorie);
        }

        $livres = $query->latest()->paginate(9);

        return response()->json([
            'livres' => $livres
        ]);
    }
}