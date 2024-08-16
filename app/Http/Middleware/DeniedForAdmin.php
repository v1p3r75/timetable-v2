<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class DeniedForAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (in_array(Auth::user()->role_id, [Role::CENSOR, Role::DEPUTY_CENSOR, Role::DIRECTOR])) {
                
                return redirect(RouteServiceProvider::ADMIN);
            }
            // if (Auth::user()->role_id == Role::TEACHER) {

            //     return redirect(RouteServiceProvider::TEACHER);
            // }
            
            return $next($request); // Redirige tous les autres utilisateurs vers la page d'accueil

        }

        return redirect('/auth/login'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
    }
}
