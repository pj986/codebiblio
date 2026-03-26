<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livre;
use Illuminate\Support\Facades\Auth;

class LivreController extends Controller
{
    public function index(Request $request)
    {
        $query = Livre::query();

        if ($request->search) {
            $query->where('titre', 'like', '%'.$request->search.'%');
        }

        if ($request->categorie) {
            $query->where('categorie', $request->categorie);
        }

        $livres = $query->paginate(9)->withQueryString();

        $categories = Livre::select('categorie')->distinct()->pluck('categorie');

        $favorisIds = [];

        if (Auth::check()) {
            $favorisIds = Auth::user()
                ->favoris()
                ->pluck('livre_id')
                ->toArray();
        }

        return view('livres.index', compact('livres','categories','favorisIds'));
    }

    public function ajax(Request $request)
    {
        $query = Livre::query();

        if ($request->search) {
            $query->where('titre', 'like', '%'.$request->search.'%');
        }

        if ($request->categorie) {
            $query->where('categorie', $request->categorie);
        }

        return response()->json($query->get());
    }
}