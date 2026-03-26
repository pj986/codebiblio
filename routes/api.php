<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\LivreApiController;

Route::get('/users', [UserApiController::class, 'index']);
Route::get('/livres', [LivreApiController::class, 'index']);