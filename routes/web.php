<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RechercheController;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\EmpruntController;
use App\Http\Controllers\FavoriController;

// BackOffice
use App\Http\Controllers\BackOffice\UserController;
use App\Http\Controllers\BackOffice\DashboardController;
use App\Http\Controllers\BackOffice\CompteController;

require __DIR__.'/auth.php';


// =========================
// 🌍 PUBLIC
// =========================

Route::get('/', [LivreController::class, 'index']);
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware(['auth']);


// =========================
// 🔐 AUTHENTIFIÉ (USER)
// =========================

Route::middleware('auth')->group(function () {

    // 👤 Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profil/{id}', [ProfilController::class, 'show']);

    // 📚 Emprunts
    Route::prefix('emprunts')->group(function () {
        Route::post('/{id}/emprunter', [EmpruntController::class, 'emprunter']);
        Route::post('/{id}/retour', [EmpruntController::class, 'retour']);
    });

    // ❤️ Favoris
    Route::post('/favori/{id}', [FavoriController::class, 'toggle']);

    // ⚡ AJAX livres
    Route::get('/ajax/livres', [LivreController::class, 'ajax']);

    // 👤 Mon espace (IMPORTANT)
    Route::get('/bo/mes-activites', [CompteController::class, 'index']);

});


// =========================
// 🛠️ ADMIN BACKOFFICE
// =========================

Route::middleware(['auth', 'admin'])->prefix('bo')->group(function () {
    Route::get('/livres', [LivreController::class, 'adminIndex']);
    Route::get('/livres/create', [LivreController::class, 'create']);
    Route::post('/livres', [LivreController::class, 'store']);
    
Route::get('/livres/{id}/edit', [LivreController::class, 'edit']);
Route::post('/livres/{id}/update', [LivreController::class, 'update']);
Route::delete('/livres/{id}', [LivreController::class, 'destroy']);

    // 📊 Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // 👥 Utilisateurs
    Route::get('/profils', [UserController::class, 'index']);
    Route::get('/profils/{id}', [UserController::class, 'show']);
    Route::delete('/profils/{id}', [UserController::class, 'destroy']);
    Route::post('/profils/{id}/unblock', [UserController::class, 'unblock']);
    
    

    Route::post('/profils/{id}/reset-password', [UserController::class, 'resetPassword']);
    Route::post('/profils/{id}/toggle-admin', [UserController::class, 'toggleAdmin']);
    Route::get('/profils/export/csv', [UserController::class, 'exportCsv']);

    // ➕ Ajout utilisateur
    Route::get('/profils/ajout', [UserController::class, 'create'])->name('admin.user.create');
    Route::post('/profils/ajout', [UserController::class, 'store'])->name('admin.user.store');

    // 🔎 Recherche
    Route::get('/recherche', [RechercheController::class, 'index']);
    Route::get('/api/recherche-livres', [RechercheController::class, 'ajax']);

    // 📷 Scanner QR
    Route::get('/scanner', function () {
        return view('scanner.index');
    });

    Route::post('/scanner/emprunter', [EmpruntController::class, 'scanEmprunt']);

});