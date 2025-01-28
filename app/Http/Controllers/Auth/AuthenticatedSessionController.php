<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
{
    

    if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
        $request->session()->regenerate();

        // Redirige según el rol del usuario
        if (Auth::user()->role === 'admin') {
            return redirect()->route('dashboard'); // Página para administradores
        }

        if (Auth::user()->role === 'cliente') {
            return redirect()->route('carrito.mostrar'); // Página para clientes
        }

        // Redirige a una página por defecto si el rol no coincide
        return redirect()->route('home');
    }

    return back()->withErrors([
        'email' => 'Credenciales incorrectas.',
    ]);
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
