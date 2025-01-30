<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsClient
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si el usuario está autenticado
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Debes iniciar sesión para acceder.');
        }

        // Verifica si el usuario tiene el rol de cliente
        if (auth()->user()->role !== 'cliente') {
            return redirect('/productosVenta')->with('error', 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
