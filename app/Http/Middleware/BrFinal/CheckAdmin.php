<?php

namespace App\Http\Middleware\BrFinal;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth('brfinal')->check() || !auth('brfinal')->user()->estAdmin()) {
            abort(403, 'Accès réservé aux administrateurs.');
        }
        return $next($request);
    }
}
