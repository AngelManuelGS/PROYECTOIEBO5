<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    /**
     * Muestra una lista de clientes.
     */
    public function index()
    {
        $clientes = Cliente::with('user')->get(); // Obtiene clientes con relación a usuarios
        return view('cliente.index', compact('clientes'));
    }

    /**
     * Muestra el formulario para crear un nuevo cliente.
     */
    public function create()
    {
        return view('cliente.create');
    }

    /**
     * Guarda un nuevo cliente en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'direccion' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'plante_educativo' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
        ]);

        // Crear el usuario relacionado
        $user = User::create([
            'name' => $validatedData['nombre'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'cliente', // Rol predeterminado
        ]);

        // Crear el cliente asociado
        Cliente::create([
            'nombre' => $validatedData['nombre'],
            'email' => $validatedData['email'],
            'telefono' => $validatedData['telefono'],
            'direccion' => $validatedData['direccion'],
            'user_id' => $user->id, // Asociar al usuario recién creado
            'plante_educativo' => $validatedData['plante_educativo'],
            'region' => $validatedData['region'],
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente creado correctamente');
    }

    /**
     * Muestra un cliente específico.
     */
    public function show($id)
    {
        $cliente = Cliente::with('user')->findOrFail($id);
        return view('cliente.show', compact('cliente'));
    }

    /**
     * Muestra el formulario para editar un cliente.
     */
    public function edit($id)
    {
        $cliente = Cliente::with('user')->findOrFail($id);
        return view('cliente.edit', compact('cliente'));
    }

    /**
     * Actualiza un cliente en la base de datos.
     */
    public function update(Request $request, Cliente $cliente)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'direccion' => 'required|string|max:255',
            'plante_educativo' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
        ]);

        // Actualizar el cliente
        $cliente->update($validatedData);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Elimina un cliente de la base de datos.
     */
    public function destroy($id)
{
    $cliente = Cliente::findOrFail($id);

    if ($cliente->user) {
        $cliente->user->delete();
    }
    $cliente->delete();

    return response()->json(['success' => true, 'message' => 'Cliente eliminado correctamente']);
}
public function buscar(Request $request)
{
    $term = $request->input('term');
    $clientes = Cliente::where('nombre', 'LIKE', "%{$term}%")
        ->orWhere('email', 'LIKE', "%{$term}%")
        ->get();

    return response()->json($clientes->map(function ($cliente) {
        return [
            'id' => $cliente->id,
            'label' => $cliente->nombre . ' (' . $cliente->email . ')',
            'value' => $cliente->nombre,
            'telefono' => $cliente->telefono,
            'direccion' => $cliente->direccion,
        ];
    }));
}

}
