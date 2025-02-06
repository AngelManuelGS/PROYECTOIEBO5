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

    // Evita el bucle infinito asegurando que no se bloquee la ruta de redirección
    if ($request->route()->getName() !== 'mis.pedidos') {
        return redirect()->route('mis.pedidos')->with('error', 'Acceso denegado, redirigiendo a tu sección principal.');
    }

    return redirect()->route('home')->with('error', 'Acceso denegado.');
}


}


