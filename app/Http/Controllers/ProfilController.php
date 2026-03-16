<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfilController extends Controller
{

    public function show($id)
    {

        $user = User::with('emprunts.exemplaires.livre')->findOrFail($id);

        return view('profil.show', compact('user'));

    }

}