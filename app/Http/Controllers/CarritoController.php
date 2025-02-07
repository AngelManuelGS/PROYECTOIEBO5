<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\Detalleventa;
use Illuminate\Support\Facades\Log;

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

    // 📌 **Calculamos la cantidad total de productos en el carrito**
    $cantidadTotalCarrito = array_sum(array_column($carrito, 'cantidad'));

    // Redirigir al carrito con un mensaje de éxito
    return response()->json([
        'success' => true,
        'cantidadTotalCarrito' => $cantidadTotalCarrito, // ✅ Total actualizado
        'nuevaCantidad' => $carrito[$productoId]['cantidad'] // ✅ Cantidad del producto actualizado
    ]);
}


    public function mostrarCarrito()
{
    $carrito = session()->get('carrito', []);

    // Actualizar la información del carrito con los datos actuales del producto
    foreach ($carrito as $productoId => &$item) {
        $producto = Producto::find($productoId);
        if ($producto) {
            $item['stock'] = $producto->stock; // Actualiza el stock con el valor más reciente de la BD
        } else {
            unset($carrito[$productoId]); // Si el producto ya no existe, lo eliminamos del carrito
        }
    }

    session()->put('carrito', $carrito); // Guardamos los cambios en la sesión

    // Calcular el total general
    $totalGeneral = array_sum(array_map(fn($item) => $item['precio'] * $item['cantidad'], $carrito));

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

        if (!$id_cliente) {
            return redirect()->route('carrito.mostrar')->with('error', 'No se encontró un cliente asociado a tu cuenta.');
        }

        $id_usuario = null; // No se guarda id_usuario porque el cliente hizo la compra
    }

    // Verificar que cada producto tenga suficiente stock antes de realizar la compra
    foreach ($carrito as $productoId => $detalle) {
        $producto = Producto::find($productoId);

        if (!$producto) {
            return redirect()->route('carrito.mostrar')->with('error', "El producto con ID {$productoId} ya no está disponible.");
        }

        if ($detalle['cantidad'] > $producto->stock) {
            return redirect()->route('carrito.mostrar')->with('error', "No hay suficiente stock para {$producto->producto}.");
        }
    }

    try {
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

            // Reducir el stock del producto
            $producto = Producto::find($productoId);
            $producto->decrement('stock', $detalle['cantidad']);
        }

        // Vaciar el carrito
        session()->forget('carrito');

        return redirect()->route('pedidos.index')->with('success', 'Compra realizada con éxito.');
    } catch (\Exception $e) {
        return redirect()->route('carrito.mostrar')->with('error', 'Hubo un problema al procesar la compra. Inténtalo de nuevo.');
    }
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

    public function actualizar(Request $request, $productoId)
{
    $request->validate([
        'cantidad' => 'required|integer|min:1'
    ]);

    $producto = \App\Models\Producto::findOrFail($productoId);

    // 📌 Verificar si la cantidad solicitada supera el stock disponible
    if ($request->cantidad > $producto->stock) {
        return redirect()->route('carrito.mostrar')->with('error', 'No hay suficiente stock disponible.');
    }

    $carrito = session()->get('carrito', []);

    if (isset($carrito[$productoId])) {
        $carrito[$productoId]['cantidad'] = $request->cantidad;
        $carrito[$productoId]['stock'] = $producto->stock; // Asegurar que el stock esté en el carrito
        session()->put('carrito', $carrito);
    }

    return redirect()->route('carrito.mostrar')->with('success', 'Cantidad actualizada correctamente.');
}



public function mostrarPedidos()
{
    // Obtener el ID del usuario autenticado (Para pruebas, puedes forzar un ID)
    $usuarioId = auth()->id();
    Log::info('Usuario ID: ' . $usuarioId);

    // Buscar el cliente correcto que coincida con el user_id en la tabla clientes
    $cliente = \App\Models\Cliente::where('user_id', $usuarioId)->first();
    Log::info('Cliente ID: ' . $cliente->id);
    // Si no se encuentra el cliente, redirigir con mensaje de error
    if (!$cliente) {
        return redirect()->route('home')->with('error', 'No tienes un cliente asociado a tu cuenta.');
    }

    // Obtener todas las ventas donde id_cliente de la tabla ventas coincide con el id del cliente encontrado
    $ventasCliente = \App\Models\Venta::where('id_cliente', $cliente->id)
        ->orderBy('created_at', 'desc')
        ->get();

    // Obtener todas las ventas realizadas por un administrador (id_usuario no es null)
    $ventasAdmin = \App\Models\Venta::where('id_cliente', $cliente->id)
        ->whereNotNull('id_usuario')
        ->orderBy('created_at', 'desc')
        ->get();

    // Retornar la vista con los datos
    return view('carrito.pedidos', compact('ventasCliente', 'ventasAdmin'));
}








}
