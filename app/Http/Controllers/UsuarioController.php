<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cliente;
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
        // Reglas básicas de validación
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:admin,cliente',
        ];

        // Validar campos adicionales solo si el rol es cliente
        if ($request->role === 'cliente') {
            $rules += [
                'telefono' => 'required|string|max:15',
                'direccion' => 'required|string|max:255',
                'plantel_educativo' => 'required|string|max:255',
                'region' => 'required|string|max:255',
            ];
        }

        $validatedData = $request->validate($rules);

        // Crear usuario
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
        ]);

        // Si el usuario es cliente, crear su registro en clientes
        if ($validatedData['role'] === 'cliente') {
            Cliente::create([
                'user_id' => $user->id,
                'nombre' => $validatedData['name'],
                'email' => $validatedData['email'],
                'telefono' => $validatedData['telefono'],
                'direccion' => $validatedData['direccion'],
                'plante_educativo' => $validatedData['plantel_educativo'],
                'region' => $validatedData['region'],
            ]);
        }

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
        // Definir reglas básicas de validación
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|string|in:admin,cliente',
        ];

        // Validar campos adicionales solo si el rol es cliente
        if ($request->role === 'cliente') {
            $rules += [
                'telefono' => 'required|string|max:15',
                'direccion' => 'required|string|max:255',
                'plantel_educativo' => 'required|string|max:255',
                'region' => 'required|string|max:255',
            ];
        }

        $validatedData = $request->validate($rules);

        // Actualizar usuario
        $usuario->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
        ]);

        if ($request->filled('password')) {
            $usuario->update(['password' => Hash::make($request->password)]);
        }

        // Si el usuario es cliente, actualizar o crear el cliente asociado
        if ($validatedData['role'] === 'cliente') {
            Cliente::updateOrCreate(
                ['user_id' => $usuario->id],
                [
                    'nombre' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'telefono' => $validatedData['telefono'],
                    'direccion' => $validatedData['direccion'],
                    'plante_educativo' => $validatedData['plantel_educativo'],
                    'region' => $validatedData['region'],
                ]
            );
        } else {
            // Si el usuario deja de ser cliente, eliminar sus datos en la tabla clientes
            Cliente::where('user_id', $usuario->id)->delete();
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id): RedirectResponse
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
