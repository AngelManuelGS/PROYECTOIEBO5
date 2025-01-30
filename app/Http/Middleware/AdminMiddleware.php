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
        if (auth()->check() && auth()->user()->role == 'admin') {
            return $next($request);
        }

        // Redirige a la sección principal del cliente si no es administrador
        return redirect()->route('pedidos')->with('error', 'Acceso denegado, redirigiendo a tu sección principal.');
    }

}


