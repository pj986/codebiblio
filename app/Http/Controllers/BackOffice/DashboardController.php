<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Livre;
use App\Models\Exemplaire;
use App\Models\User;
use App\Models\Emprunt;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {

        $livres = Livre::count();

        $exemplaires = Exemplaire::count();

        $users = User::count();

        $empruntsEnCours = Exemplaire::where('disponible', false)->count();

        $topLivres = DB::table('exemplaires')
            ->join('livres','exemplaires.livre_id','=','livres.id')
            ->select('livres.titre', DB::raw('count(*) as total'))
            ->where('exemplaires.disponible', false)
            ->groupBy('livres.titre')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('bo.dashboard', compact(
            'livres',
            'exemplaires',
            'users',
            'empruntsEnCours',
            'topLivres'
        ));

    }

}