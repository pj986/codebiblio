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

public function adminIndex()
{
    $livres = \App\Models\Livre::latest()->get();
    return view('bo.livres.index', compact('livres'));
}

public function create()
{
    return view('bo.livres.create');
}

public function store(Request $request)
{
    $request->validate([
        'titre' => 'required',
        'auteur' => 'required',
        'categorie' => 'required',
        'image' => 'required|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    // 📸 upload image
    $imageName = time() . '.' . $request->image->extension();

    $request->image->move(public_path('images'), $imageName);

    // 💾 sauvegarde
    \App\Models\Livre::create([
        'titre' => $request->titre,
        'auteur' => $request->auteur,
        'description' => $request->description,
        'categorie' => $request->categorie,
        'couverture' => $imageName
    ]);

    return redirect('/bo/livres')->with('success', 'Livre ajouté');
}
// ✏️ EDIT
public function edit($id)
{
    $livre = Livre::findOrFail($id);
    return view('bo.livres.edit', compact('livre'));
}

// 🔄 UPDATE
public function update(Request $request, $id)
{
    $livre = Livre::findOrFail($id);

    $request->validate([
        'titre' => 'required',
        'auteur' => 'required',
        'categorie' => 'required'
    ]);

    // 📸 image (optionnelle)
    if ($request->hasFile('image')) {
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $livre->couverture = $imageName;
    }

    $livre->update([
        'titre' => $request->titre,
        'auteur' => $request->auteur,
        'description' => $request->description,
        'categorie' => $request->categorie,
        'couverture' => $livre->couverture
    ]);

    return redirect('/bo/livres')->with('success', 'Livre modifié');
}

// ❌ DELETE
public function destroy($id)
{
    Livre::findOrFail($id)->delete();
    return back()->with('success', 'Livre supprimé');
}