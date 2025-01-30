<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto; // Asegúrate de importar el modelo

class ProductoVentaController extends Controller
{
    public function index()
    {
        $productos = Producto::all(); // Obtiene todos los productos de la BD

        return view('productosVenta.index', compact('productos')); // Enviar datos a la vista
    }
}

