<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use App\Models\Cliente;

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
            'role' => 'required|string|in:admin,cliente', // Validamos que sea "admin" o "cliente"
            'telefono' => 'nullable|string|max:15', // Solo si es cliente
            'direccion' => 'nullable|string|max:255',
            'plantel_educativo' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
        ]);

        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Si el usuario es un cliente, crear también un registro en "clientes"
        if ($request->role === 'cliente') {
            Cliente::create([
                'user_id' => $user->id,
                'nombre' => $request->name,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'plante_educativo' => $request->plantel_educativo,
                'region' => $request->region,
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

    // Si el usuario es cliente, los campos adicionales son obligatorios
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
    if ($request->role === 'cliente') {
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
}
