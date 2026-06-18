<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
{
    if (auth()->check() && auth()->user()->blocked) {
        auth()->logout();
        return redirect('/login')->with('error', 'Compte bloqué');
    }

    return $next($request);
}
}
