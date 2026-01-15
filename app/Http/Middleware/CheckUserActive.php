<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         if (Auth::check()) {
            // Vérifier si l'utilisateur est actif OU s'il est admin
            if (Auth::user()->is_active || Auth::user()->role === 'admin') {
                return $next($request);
            }
            
            // Si l'utilisateur n'est pas actif, le déconnecter et rediriger
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Votre compte est en attente d\'activation par un administrateur.');
        }
        
        return $next($request);
    }
}
