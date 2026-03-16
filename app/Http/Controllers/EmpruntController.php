<?php

namespace App\Http\Controllers;

use App\Models\Exemplaire;
use App\Models\Emprunt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\LivreEmprunteMail;

class EmpruntController extends Controller
{

    public function emprunter($id)
    {

        $exemplaire = Exemplaire::findOrFail($id);

        if(!$exemplaire->disponible){
            return back()->with('error','Exemplaire indisponible');
        }

        $emprunt = Emprunt::create([
            'user_id' => 1,
            'date_emprunt' => now(),
            'date_retour_prevue' => now()->addDays(30)
        ]);

        DB::table('emprunt_exemplaire')->insert([
            'emprunt_id' => $emprunt->id,
            'exemplaire_id' => $exemplaire->id
        ]);

        $exemplaire->update([
            'disponible' => false
        ]);

        return back()->with('success','Livre emprunté');
        Mail::to(auth()->user()->email)->send(
    new LivreEmprunteMail(
        $exemplaire->livre->titre,
        now()->addDays(30)
    )
);

    }

    public function retour($id)
    {

        $exemplaire = Exemplaire::findOrFail($id);

        $exemplaire->update([
            'disponible' => true
        ]);

        return back()->with('success','Livre retourné');

    }
    public function scanEmprunt(Request $request)
{

    $exemplaire = Exemplaire::find($request->exemplaire_id);

    if(!$exemplaire){
        return response()->json(['error'=>'Exemplaire introuvable']);
    }

    if(!$exemplaire->disponible){
        return response()->json(['error'=>'Livre déjà emprunté']);
    }

    $emprunt = Emprunt::create([
        'user_id' => auth()->id(),
        'date_emprunt' => now(),
        'date_retour_prevue' => now()->addDays(30)
    ]);

    $emprunt->exemplaires()->attach($exemplaire->id);

    $exemplaire->disponible = false;
    $exemplaire->save();

    return response()->json(['success'=>'Livre emprunté']);

}

}