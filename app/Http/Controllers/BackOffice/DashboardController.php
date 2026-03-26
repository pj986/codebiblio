<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Livre;
use App\Models\Emprunt;

class DashboardController extends Controller
{

    public function index()
    {

        $totalUsers = User::count();
        $totalLivres = Livre::count();
        $totalEmprunts = Emprunt::count();
        $empruntsActifs = Emprunt::count();

        return view('bo.dashboard', [
            'totalUsers' => $totalUsers,
            'totalLivres' => $totalLivres,
            'totalEmprunts' => $totalEmprunts,
            'empruntsActifs' => $empruntsActifs
        ]);

    }

}