<?php

namespace App\Http\Controllers;

use App\Models\Exemplaire;
use App\Models\Livre;
use Illuminate\Http\Request;

class BackOfficeExemplaireController extends Controller
{

    public function index()
    {
        $exemplaires = Exemplaire::with('livre')->get();

        return view('bo.exemplaires.index', compact('exemplaires'));
    }

    public function create()
    {
        $livres = Livre::all();

        return view('bo.exemplaires.create', compact('livres'));
    }

    public function store(Request $request)
    {

        Exemplaire::create([
            'livre_id' => $request->livre_id,
            'etat' => $request->etat,
            'disponible' => true
        ]);

        return redirect('/bo/exemplaires');
    }

    public function edit($id)
    {
        $exemplaire = Exemplaire::findOrFail($id);
        $livres = Livre::all();

        return view('bo.exemplaires.edit', compact('exemplaire','livres'));
    }

    public function update(Request $request, $id)
    {

        $exemplaire = Exemplaire::findOrFail($id);

        $exemplaire->update([
            'livre_id' => $request->livre_id,
            'etat' => $request->etat
        ]);

        return redirect('/bo/exemplaires');
    }

    public function destroy($id)
    {

        Exemplaire::destroy($id);

        return redirect('/bo/exemplaires');

    }

}