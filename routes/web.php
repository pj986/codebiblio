<?php

use Illuminate\Support\Facades\Route;

// =========================
// 🌍 PUBLIC
// =========================
use App\Http\Controllers\LivreController;
use App\Http\Controllers\AuthController;

Route::get('/', [LivreController::class, 'index'])->name('catalogue');
// 📖 PAGE LIVRE (QR + détail)
Route::get('/livre/{id}', [LivreController::class, 'show'])->name('livre.show');

Route::get('/2fa', [AuthController::class, 'show2FA']);
Route::post('/2fa', [AuthController::class, 'verify2FA']);

// AUTH
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================
// 🔐 AUTHENTIFIÉ (USER)
// =========================
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\EmpruntController;
use App\Http\Controllers\FavoriController;
use App\Http\Controllers\BackOffice\CompteController;
use App\Http\Controllers\DashboardController; 


Route::middleware(['auth','blocked'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

    // 👤 PROFIL
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profil/{id}', [ProfilController::class, 'show'])->name('profil.show');

    // 📚 EMPRUNTS
Route::prefix('emprunts')->group(function () {

    Route::post('/{id}/emprunter', [EmpruntController::class, 'emprunter'])
        ->middleware(['anti.spam','throttle:5,1'])
        ->name('emprunter');

    Route::post('/{id}/retour', [EmpruntController::class, 'retour'])
        ->middleware(['throttle:10,1'])
        ->name('retourner');

}); 
    // 📚 MES EMPRUNTS
    Route::get('/mes-emprunts', [EmpruntController::class, 'mesEmprunts'])->name('mes.emprunts');
    Route::get('/ajax/emprunts', [EmpruntController::class, 'ajax'])->name('ajax.emprunts');

    // ❤️ FAVORIS
    Route::post('/favori/{id}', [FavoriController::class, 'toggle'])->name('favori.toggle');

    // ⚡ AJAX LIVRES
    Route::get('/ajax/livres', [LivreController::class, 'ajax'])->name('ajax.livres');

    // 👤 MON ESPACE BACK OFFICE (user activité)
    Route::get('/bo/mes-activites', [CompteController::class, 'index'])->name('user.activites');
   
});

// =========================
// 🛠️ ADMIN BACK OFFICE
// =========================
use App\Http\Controllers\BackOffice\UserController;
use App\Http\Controllers\BackOffice\DashboardController as AdminDashboardController;
use App\Http\Controllers\RechercheController;

Route::middleware(['auth','admin'])->prefix('bo')->group(function () {

    // 📊 DASHBOARD
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    // 👥 UTILISATEURS
    Route::get('profils', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('profils/{id}', [UserController::class, 'show'])->name('admin.users.show');
    Route::delete('profils/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('profils/{id}/unblock', [UserController::class, 'unblock'])->name('admin.users.unblock');

    Route::post('/profils/{id}/reset-password', [UserController::class, 'resetPassword'])->name('admin.users.reset');
    Route::post('/profils/{id}/toggle-admin', [UserController::class, 'toggleAdmin'])->name('admin.users.toggleAdmin');

    // ➕ AJOUT UTILISATEUR
    Route::get('/profils/ajout', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/profils/ajout', [UserController::class, 'store'])->name('admin.users.store');

    // 📚 LIVRES
    Route::get('/livres', [LivreController::class, 'adminIndex'])->name('admin.livres.index');
    Route::get('/livres/create', [LivreController::class, 'create'])->name('admin.livres.create');
    Route::post('/livres', [LivreController::class, 'store'])->name('admin.livres.store');
    Route::get('/livres/{id}/edit', [LivreController::class, 'edit'])->name('admin.livres.edit');
    Route::post('/livres/{id}/update', [LivreController::class, 'update'])->name('admin.livres.update');
    Route::delete('/livres/{id}', [LivreController::class, 'destroy'])->name('admin.livres.destroy');

    // 🔎 RECHERCHE ADMIN
    Route::get('/recherche', [RechercheController::class, 'index'])->name('admin.recherche');
    Route::get('/api/recherche-livres', [RechercheController::class, 'ajax'])->name('admin.ajax.livres');

    // 📷 SCANNER QR
    Route::get('/scanner', function () { return view('scanner.index'); })->name('admin.scanner');
    Route::post('/scanner/emprunter', [EmpruntController::class, 'scanEmprunt'])
    ->middleware('throttle:10,1');
    Route::post('/scanner/retour', [EmpruntController::class, 'scanRetour'])
    ->middleware('throttle:10,1');

});
   