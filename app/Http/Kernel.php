<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Global HTTP middleware stack
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * Route middleware groups
     */
    protected $middlewareGroups = [

        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,

            // 🔥 CSRF protection
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,

            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Route middleware (les tiens ici 🔥)
     */
    protected $routeMiddleware = [

        // 🔐 AUTH
        'auth' => \App\Http\Middleware\Authenticate::class,

        // 🔐 ADMIN
        'admin' => \App\Http\Middleware\AdminMiddleware::class,

        // 🚫 USER BLOQUÉ
        'blocked' => \App\Http\Middleware\CheckUserBlocked::class,

        // ⚡ ANTI SPAM
        'anti.spam' => \App\Http\Middleware\PreventSpam::class,

        // 🔥 RATE LIMIT
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // AUTRES LARAVEL
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'blocked' => \App\Http\Middleware\CheckBlocked::class,
    ];
}