<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class UsuarioController extends Controller
{
    public function index(): View
    {
        $usuarios = User::all();
        return view('usuario.index', compact('usuarios'));
    }

    public function create(): View
    {
        $usuario = new User(); // Instancia vacía de User
        return view('usuario.create', compact('usuario')); // Pasar $usuario a la vista
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function show($id): View
    {
        $usuario = User::findOrFail($id);
        return view('usuario.show', compact('usuario'));
    }

    public function edit($id): View
    {
        $usuario = User::findOrFail($id);
        return view('usuario.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:6',
            'rol' => 'required|string|in:admin,user', // Ahora validamos el rol
        ]);
    
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->rol, // Se agrega el campo rol
        ];
    
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
    
        $usuario->update($data);
    
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }
    

    public function destroy($id): RedirectResponse
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
