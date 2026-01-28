<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Gère l'accès en fonction du rôle.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles (Liste des rôles autorisés)
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // 3. Si non autorisé
        abort(403, "Action non autorisée pour votre rôle ($userRole).");
    }
}