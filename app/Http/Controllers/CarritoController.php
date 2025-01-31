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

    public function finalizarCompra(Request $request)
{
    $carrito = session()->get('carrito', []);

    if (empty($carrito)) {
        return redirect()->route('carrito.mostrar')->with('error', 'El carrito está vacío.');
    }

    // Si el usuario es un administrador, toma el id_cliente del formulario, si es cliente, busca su ID en la tabla clientes
    if (auth()->user()->isAdmin()) {
        $id_cliente = $request->input('id_cliente'); // Admin selecciona un cliente
        $id_usuario = auth()->id(); // Guardar ID del admin
    } else {
        // Buscar el ID del cliente asociado al usuario autenticado
        $id_cliente = \App\Models\Cliente::where('user_id', auth()->id())->value('id');
        $id_usuario = null; // No se guarda id_usuario porque el cliente hizo la compra
    }

    // Verificar que el cliente exista
    if (!$id_cliente) {
        return redirect()->route('carrito.mostrar')->with('error', 'No se encontró un cliente asociado a tu cuenta.');
    }

    // Crear la venta con los datos corregidos
    $venta = Venta::create([
        'total' => array_sum(array_map(fn($item) => $item['precio'] * $item['cantidad'], $carrito)),
        'id_cliente' => $id_cliente,  // Cliente real
        'id_usuario' => $id_usuario,  // Admin si aplica, NULL si es un cliente
    ]);

    foreach ($carrito as $productoId => $detalle) {
        Detalleventa::create([
            'id_venta' => $venta->id,
            'id_producto' => $productoId,
            'cantidad' => $detalle['cantidad'],
            'precio' => $detalle['precio'],
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
    public function actualizar(Request $request, $productoId)
{
    $request->validate([
        'cantidad' => 'required|integer|min:1'
    ]);

    $carrito = session()->get('carrito', []);

    if (isset($carrito[$productoId])) {
        $carrito[$productoId]['cantidad'] = $request->cantidad;
        session()->put('carrito', $carrito);
    }

    return redirect()->route('carrito.mostrar')->with('success', 'Cantidad actualizada.');
}

}
