<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\Detalleventa;

class HomeController extends Controller
{
    public function index()
    {
        // Verifica si el usuario tiene permisos adicionales o roles
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Por favor, inicia sesión.');
        }

        // Redirige a la sección "Mi Carrito" en lugar de mostrar una vista
        return redirect()->route('carrito.mostrar');
    }
}

class CarritoController extends Controller
{
    // Mostrar productos disponibles
    public function index()
    {
        $productos = Producto::where('stock', '>', 0)->get();
        return view('productosVenta.index', compact('productos'));
    }

    public function agregar(Request $request, $productoId)
    {
        // Buscar el producto en la base de datos
        $producto = Producto::findOrFail($productoId);

        // Obtener el carrito actual desde la sesión o inicializar uno vacío
        $carrito = session()->get('carrito', []);

        // Si el producto ya está en el carrito, incrementa la cantidad
        if (isset($carrito[$productoId])) {
            $carrito[$productoId]['cantidad'] += $request->input('cantidad', 1);
        } else {
            // Si no está en el carrito, agrega sus datos
            $carrito[$productoId] = [
                'nombre' => $producto->producto, // Nombre del producto
                'precio' => $producto->precio_venta, // Precio de venta del producto
                'cantidad' => $request->input('cantidad', 1), // Cantidad solicitada
            ];
        }

        // Guardar el carrito actualizado en la sesión
        session()->put('carrito', $carrito);

        // Redirigir al carrito con un mensaje de éxito
        return redirect()->route('carrito.mostrar')->with('success', 'Producto agregado al carrito.');
    }

    public function mostrarCarrito()
    {
        $carrito = session()->get('carrito', []);

        // Calcular el total general
        $totalGeneral = array_sum(array_map(fn($item) => $item['precio'] * $item['cantidad'], $carrito));

        // Retornar la vista con los datos del carrito y el total general
        return view('carrito.show', compact('carrito', 'totalGeneral'));
    }

    public function finalizarCompra()
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito.mostrar')->with('error', 'El carrito está vacío.');
        }

        // Crear la venta
        $venta = Venta::create([
            'total' => array_sum(array_map(fn($item) => $item['precio'] * $item['cantidad'], $carrito)),
            'id_cliente' => auth()->id(), // ID del cliente autenticado
            'id_usuario' => auth()->id(), // O el usuario que registra la venta
        ]);

        foreach ($carrito as $productoId => $detalle) {
            Detalleventa::create([
                'id_venta' => $venta->id, // ID de la venta
                'id_producto' => $productoId, // ID del producto
                'cantidad' => $detalle['cantidad'], // Cantidad comprada
                'precio' => $detalle['precio'], // Precio unitario
            ]);

            // Actualizar stock del producto
            $producto = Producto::find($productoId);
            $producto->decrement('stock', $detalle['cantidad']);
        }

        // Vaciar el carrito
        session()->forget('carrito');

        return redirect()->route('productosVenta.index')->with('success', 'Compra realizada con éxito.');
    }

    public function remover($productoId)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$productoId])) {
            unset($carrito[$productoId]);
            session()->put('carrito', $carrito);
        }

        return redirect()->route('carrito.mostrar')->with('success', 'Producto eliminado del carrito.');
    }

    public function mostrarPedidos()
    {
        // Obtén todos los pedidos realizados por el usuario autenticado
        $pedidos = Venta::with('detalles.producto')->where('id_cliente', auth()->id())->get();

        // Retorna una vista con los pedidos
        return view('pedidos.index', compact('pedidos'));
    }
}
