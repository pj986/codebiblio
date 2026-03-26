<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livre;

class RechercheController extends Controller
{

    public function index(Request $request)
{
    $query = Livre::query();

    if ($request->titre) {
        $query->where('titre', 'like', '%' . $request->titre . '%');
    }

    if ($request->auteur) {
        $query->where('auteur', 'like', '%' . $request->auteur . '%');
    }

    if ($request->categorie) {
        $query->where('categorie', $request->categorie);
    }

    if ($request->disponible) {
        $query->whereHas('exemplaires', function($q) {
            $q->where('disponible', true);
        });
    }

    $livres = $query->get();

    return view('recherche.index', compact('livres'));
}
    public function ajax(Request $request)
{

    $q = $request->q;

    $livres = Livre::where('titre','like','%'.$q.'%')
        ->orWhere('auteur','like','%'.$q.'%')
        ->limit(10)
        ->get();

    return response()->json($livres);

}

}