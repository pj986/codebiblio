<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminLog;
use Symfony\Component\HttpFoundation\StreamedResponse;
class UserController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'id');
        $dir  = $request->get('dir', 'asc');

        $query = User::withCount('emprunts');

        // 🔎 Recherche
        if ($request->search) {
            $query->where(function($q) use ($request){
                $q->where('name','like','%'.$request->search.'%')
                  ->orWhere('email','like','%'.$request->search.'%');
            });
        }

        // 🔍 Filtre rôle
        if ($request->role) {
            $query->where('role', $request->role);
        }

        // 🔍 Filtre bloqué
        if ($request->blocked !== null) {
            $query->where('is_blocked', $request->blocked);
        }

        $users = $query->orderBy($sort, $dir)
            ->paginate(10)
            ->withQueryString();

        return view('bo.profils.index', compact('users'));
    }

    public function toggleAdmin($id)
    {
        $user = User::findOrFail($id);

        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();

        AdminLog::create([
            'action' => 'Changement rôle',
            'target' => $user->email
        ]);

        return back()->with('success', 'Rôle mis à jour.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        AdminLog::create([
            'action' => 'Suppression utilisateur',
            'target' => $user->email
        ]);

        $user->delete();

        return back()->with('success', 'Utilisateur supprimé.');
    }

    public function unblock($id)
    {
        $user = User::findOrFail($id);

        $user->is_blocked = false;
        $user->save();

        AdminLog::create([
            'action' => 'Déblocage',
            'target' => $user->email
        ]);

        return back()->with('success', 'Compte débloqué.');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        $user->password = Hash::make('password');
        $user->save();

        AdminLog::create([
            'action' => 'Reset MDP',
            'target' => $user->email
        ]);

        return back()->with('success', 'Mot de passe reset.');
    }
    public function exportCsv()
{
    $filename = "users.csv";

    $users = User::all();

    $response = new StreamedResponse(function() use ($users){
        $handle = fopen('php://output', 'w');

        fputcsv($handle, ['ID','Nom','Email','Role']);

        foreach ($users as $user) {
            fputcsv($handle, [
                $user->id,
                $user->name,
                $user->email,
                $user->role
            ]);
        }

        fclose($handle);
    });

    $response->headers->set('Content-Type','text/csv');
    $response->headers->set('Content-Disposition','attachment; filename="'.$filename.'"');

    return $response;
}
public function show($id, Request $request)
{
    // Récupère l'utilisateur avec ses emprunts et exemplaires associés
    $user = \App\Models\User::with(['emprunts.exemplaires.livre'])
        ->findOrFail($id);

    // Tri dynamique basé sur la requête (par défaut, tri par date d'emprunt)
    $sortBy = $request->get('sortBy', 'date_emprunt');
    $sortDir = $request->get('sortDir', 'desc');

    // Récupère les emprunts de l'utilisateur avec tri
    $empruntsQuery = $user->emprunts()->orderBy($sortBy, $sortDir);

    // Exécute la requête pour obtenir les emprunts triés
    $emprunts = $empruntsQuery->get();

    return view('bo.profils.show', compact('user', 'emprunts', 'sortBy', 'sortDir'));
}
public function store(Request $request)
{
    // Validation des données
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',  // Validation du mot de passe et de la confirmation
        'role' => 'required|in:user,admin'
    ],
    [
    'name.required' => 'Le nom est obligatoire.',
    'email.required' => 'L\'email est obligatoire.',
    'email.unique' => 'Cet email est déjà utilisé.',
    'password.required' => 'Le mot de passe est obligatoire.',
    'password.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
    'role.required' => 'Le rôle est obligatoire.',
    'role.in' => 'Le rôle doit être soit "utilisateur" soit "administrateur".',
]);

    // Création de l'utilisateur
    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);  // Hachage du mot de passe
    $user->role = $request->role;
    $user->save();

    return redirect()->route('bo.profils.index')->with('success', 'Utilisateur ajouté avec succès.');
}
}