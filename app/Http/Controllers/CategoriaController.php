<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Muestra una lista de categorías.
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view('categoria.index', compact('categorias'));
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     */
    public function create()
    {
        // Enviar una instancia vacía de Categoria para evitar errores en la vista
        $categoria = new Categoria();
        return view('categoria.create', compact('categoria'));
    }

    /**
     * Guarda una nueva categoría en la base de datos.
     */

    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255|unique:categorias,nombre',
        'anio' => 'required|integer|min:2000|max:2100',
        'ciclo' => 'required|string|in:A,B',
    ]);

    Categoria::create([
        'nombre' => $request->nombre,
        'anio' => $request->anio,
        'ciclo' => $request->ciclo,
    ]);

    return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
}


    /**
     * Muestra el formulario para editar una categoría.
     */
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categoria.edit', compact('categoria'));
    }

    /**
     * Actualiza una categoría en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);

        // Validación
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id,
            'anio' => 'required|integer|min:2000|max:2100',
            'ciclo' => 'required|string|in:A,B',
        ]);

        // Actualizar la categoría
        $categoria->update([
            'nombre' => $request->nombre,
            'anio' => $request->anio,
            'ciclo' => $request->ciclo,
        ]);

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Elimina una categoría de la base de datos.
     */
    public function destroy($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['success' => false, 'message' => 'Categoría no encontrada'], 404);
        }

        try {
            $categoria->delete();
            return response()->json(['success' => true, 'message' => 'Categoría eliminada exitosamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar la categoría'], 500);
        }
    }

}
