<?php

namespace App\Http\Middleware\BrFinal;

use Closure;
use Illuminate\Http\Request;

class CheckMembre
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth('brfinal')->check()) {
            return redirect()->route('br.login');
        }

        $user = auth('brfinal')->user();
        if ($user->statut === 'suspendu') {
            auth('brfinal')->logout();
            return redirect()->route('br.login')->with('error', 'Votre compte est suspendu.');
        }

        return $next($request);
    }
}
