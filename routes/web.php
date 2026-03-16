<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\BackOffice\UserController;
use App\Http\Controllers\BackOffice\DashboardController;
use App\Http\Controllers\RechercheController;


use App\Http\Controllers\LivreController;
use App\Http\Controllers\EmpruntController;

Route::get('/', [LivreController::class,'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('/emprunter/{id}', [EmpruntController::class, 'emprunter'])->middleware('auth');

Route::post('/retour/{id}', [EmpruntController::class, 'retour'])->middleware('auth');
Route::get('/profil/{id}', [ProfilController::class, 'show'])->middleware('auth');
Route::middleware(['auth'])->prefix('bo')->group(function () {

    Route::get('/profils', [UserController::class,'index']);

    Route::get('/profils/{id}', [UserController::class,'show']);

    Route::delete('/profils/{id}', [UserController::class,'destroy']);
    Route::post('/profils/{id}/unblock', [UserController::class, 'unblock']);
    Route::get('/dashboard', [DashboardController::class,'index']);
    Route::get('/recherche', [RechercheController::class,'index']);
    Route::get('/api/recherche-livres', [RechercheController::class, 'ajax']);
    Route::get('/scanner', function(){
    return view('scanner.index');
})->middleware('auth');

Route::post('/scanner/emprunter', [EmpruntController::class, 'scanEmprunt'])
    ->middleware('auth');

});

require __DIR__.'/auth.php';
