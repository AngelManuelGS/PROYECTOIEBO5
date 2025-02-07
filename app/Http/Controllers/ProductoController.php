<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Muestra una lista de productos.
     */
    public function index()
    {
        $productos = Producto::with('categoria')->get();
        return view('producto.index', compact('productos'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
        $categorias = Categoria::pluck('nombre', 'id');
        $producto = new Producto(); // Producto vacío para evitar errores en la vista
        return view('producto.create', compact('categorias', 'producto'));
    }

    /**
     * Guarda un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de los campos
        $request->validate([
            'codigo' => 'required|string|max:50|unique:productos,codigo',
            'producto' => 'required|string|max:255',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'id_categoria' => 'required|exists:categorias,id',
            'stock' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Manejo de la imagen
        $imagePath = null;
        if ($request->hasFile('foto')) {
            $imagePath = $request->file('foto')->store('uploads', 'public');
        }

        // Crear el producto
        Producto::create([
            'codigo' => $request->codigo,
            'producto' => $request->producto,
            'precio_compra' => $request->precio_compra,
            'precio_venta' => $request->precio_venta,
            'foto' => $imagePath,
            'id_categoria' => $request->id_categoria,
            'stock' => $request->stock,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un producto.
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::pluck('nombre', 'id');
        return view('producto.edit', compact('producto', 'categorias'));
    }

    /**
     * Actualiza un producto en la base de datos.
     */
    public function update(Request $request, Producto $producto)
    {
        // Validación de los campos
        $request->validate([
            'codigo' => 'required|string|max:50|unique:productos,codigo,' . $producto->id,
            'producto' => 'required|string|max:255',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'id_categoria' => 'required|exists:categorias,id',
            'stock' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Manejo de la imagen
        $imagePath = $producto->foto;
        if ($request->hasFile('foto')) {
            // Eliminar la imagen anterior si existe
            if ($producto->foto && Storage::disk('public')->exists($producto->foto)) {
                Storage::disk('public')->delete($producto->foto);
            }

            // Guardar la nueva imagen
            $imagePath = $request->file('foto')->store('uploads', 'public');
        }

        // Actualizar el producto
        $producto->update([
            'codigo' => $request->codigo,
            'producto' => $request->producto,
            'precio_compra' => $request->precio_compra,
            'precio_venta' => $request->precio_venta,
            'foto' => $imagePath,
            'id_categoria' => $request->id_categoria,
            'stock' => $request->stock,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Elimina un producto de la base de datos.
     */
    public function destroy($id)
{
    $producto = Producto::findOrFail($id);
    $producto->delete();

    return response()->json(['success' => true, 'message' => 'Producto eliminado correctamente']);
}



    public function productosVenta()
{
    $productos = Producto::all(); // Obtiene todos los productos desde la base de datos
    return view('productosVenta.index', compact('productos')); // Envía los productos a la vista
}

public function reducirStock($productoId, $cantidad)
{
    $producto = Producto::findOrFail($productoId);

    // Validar que la cantidad no sea mayor al stock disponible
    if ($producto->stock < $cantidad) {
        return back()->with('error', 'Stock insuficiente para este producto.');
    }

    // Restar la cantidad sin permitir valores negativos
    $producto->stock = max(0, $producto->stock - $cantidad);
    $producto->save();
}



}
