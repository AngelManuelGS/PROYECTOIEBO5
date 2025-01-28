<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Verifica si el usuario tiene permisos adicionales o roles
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Por favor, inicia sesión.');
        }

        // Redirige a "Mis Pedidos" en lugar de mostrar una vista
        return redirect()->route('pedidos');
    }
}
