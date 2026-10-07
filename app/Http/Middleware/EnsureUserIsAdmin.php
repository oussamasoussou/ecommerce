<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Réserve le back-office aux administrateurs (rôles super-admin et admin).
 */
class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || !$user->isAdmin()) {
            if ($request->expectsJson()) {
                abort(403, 'Accès réservé aux administrateurs.');
            }

            // Un client connecté est renvoyé vers la boutique, un visiteur vers le login admin
            return $user
                ? redirect('/')->with('error', 'Accès réservé aux administrateurs.')
                : redirect()->route('login');
        }

        return $next($request);
    }
}
