<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\BackOffice\UserController;
use App\Http\Controllers\BackOffice\DashboardController;
use App\Http\Controllers\RechercheController;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\EmpruntController;
use App\Http\Controllers\FavoriController;

Route::get('/', [LivreController::class,'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('emprunts')->group(function () {
    Route::post('/{id}/emprunter', [EmpruntController::class, 'emprunter']);
    Route::post('/{id}/retour', [EmpruntController::class, 'retour']);
});
    Route::get('/profil/{id}', [ProfilController::class, 'show']);
     // ❤️ FAVORIS
    Route::post('/favori/{id}', [FavoriController::class, 'toggle']);
    Route::get('/ajax/livres', [LivreController::class, 'ajax']);
    Route::post('/ajax/favori/{id}', [FavoriController::class, 'toggleAjax'])->middleware('auth');

});

Route::middleware(['auth','admin'])->prefix('bo')->group(function () {

    Route::get('/dashboard', [DashboardController::class,'index']);

    Route::get('/profils', [UserController::class,'index']);
    Route::get('/profils/{id}', [UserController::class,'show']);
    Route::delete('/profils/{id}', [UserController::class,'destroy']);
    Route::post('/profils/{id}/unblock', [UserController::class, 'unblock']);

    Route::get('/recherche', [RechercheController::class,'index']);
    Route::get('/api/recherche-livres', [RechercheController::class, 'ajax']);

    Route::get('/scanner', function(){
        return view('scanner.index');
    });

    Route::post('/scanner/emprunter', [EmpruntController::class, 'scanEmprunt']);

    Route::post('/profils/{id}/reset-password', [UserController::class, 'resetPassword']);
    Route::post('/profils/{id}/toggle-admin', [UserController::class, 'toggleAdmin']);
    Route::get('/profils/export/csv', [UserController::class, 'exportCsv']);

});

require __DIR__.'/auth.php';