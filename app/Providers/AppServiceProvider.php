<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;


use Illuminate\Support\Facades\View;
use App\Models\Favori;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Correction problème MySQL index length
        Schema::defaultStringLength(191);

        // Protection anti brute-force login
        RateLimiter::for('login', function (Request $request) {

            return Limit::perMinute(5)->by($request->ip());

        });

        // ❤️ COMPTEUR FAVORIS GLOBAL
        View::composer('*', function ($view) {

            $countFavoris = 0;

            if (auth()->check()) {
                $countFavoris = Favori::where('user_id', auth()->id())->count();
            }

            $view->with('countFavoris', $countFavoris);
        });
    }
}