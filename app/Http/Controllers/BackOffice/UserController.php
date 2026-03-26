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
}