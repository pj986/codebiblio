<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfilController extends Controller
{

    public function show($id)
{
    if(auth()->id() != $id){
        abort(403);
    }

    $user = User::findOrFail($id);

    return view('profil.show', compact('user'));
}
}