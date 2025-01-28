<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si el usuario está autenticado
        if (!auth()->check()) {
            abort(403, 'Acceso denegado. Usuario no autenticado.');
        }

        // Verifica si el usuario tiene el rol de administrador
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Acceso denegado. No tienes permisos de administrador.');
        }

        return $next($request);
    }
}


