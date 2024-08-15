<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DeniedForStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
         if (Auth::check()) {
            if (in_array(Auth::user()->role_id, [Role::CENSOR, Role::DEPUTY_CENSOR, Role::DIRECTOR])) {
                
                return $next($request); // Permet l'accès aux administrateurs (role_id = 1)
            }
            if (Auth::user()->role_id == Role::TEACHER) {

                return redirect(RouteServiceProvider::TEACHER);
            }

            return redirect(RouteServiceProvider::STUDENT); // Redirige tous les autres utilisateurs vers la page d'accueil

        }

        return redirect('/auth/login'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
    }
}
