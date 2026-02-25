<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si el usuario está autenticado
        if (!Auth::check()) {
            // Redirige al usuario a la página de inicio de sesión
            return redirect()->route('admin')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }

        // Permite continuar si el usuario está logueado
        return $next($request);

    }
}
