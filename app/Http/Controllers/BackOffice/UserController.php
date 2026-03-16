<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {

        $users = User::withCount('emprunts')->get();

        return view('bo.profils.index', compact('users'));

    }

    public function show($id)
    {

        $user = User::with('emprunts.exemplaires.livre')->findOrFail($id);

        return view('bo.profils.show', compact('user'));

    }

    public function destroy($id)
    {

        $user = User::findOrFail($id);

        $user->delete();

        return redirect('/bo/profils')->with('success','Utilisateur supprimé');

    }
    public function unblock($id)
{
    $user = \App\Models\User::findOrFail($id);

    $user->is_blocked = false;
    $user->login_attempts = 0;

    $user->save();

    return redirect('/bo/profils')->with('success', 'Compte débloqué');
}

}