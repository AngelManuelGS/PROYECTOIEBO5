<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Compania;
use App\Models\Detalleventa;
use App\Models\Venta;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

/**
 * Class VentaController
 * @package App\Http\Controllers
 */
class VentaController extends Controller
{
    public function index()
    {
        return view('venta.index');
    }

    public function store(Request $request)
{
    $request->validate([
        'id_cliente' => 'nullable|exists:clientes,id', 
    ]);

    $id_cliente = (int) $request->id_cliente; 
    $total = (float) Cart::subtotal();
    $id_usuario = Auth::check() ? Auth::id() : null; // Si hay usuario autenticado, se guarda su ID

    if ($total > 0) {
        $sale = Venta::create([
            'total' => $total,
            'id_cliente' => $id_cliente, 
            'id_usuario' => $id_usuario, // Se almacena el usuario si existe
            'estado' => 'pendiente',
        ]);

        foreach (Cart::content() as $item) {
            Detalleventa::create([
                'precio' => $item->price,
                'cantidad' => $item->qty,
                'id_producto' => $item->id,
                'id_venta' => $sale->id,
            ]);
        }

        Cart::destroy();

        return response()->json([
            'title' => 'VENTA GENERADA',
            'message' => 'La venta ha sido registrada exitosamente.',
            'icon' => 'success',
            'ticket' => $sale->id,
        ]);
    }

    return response()->json([
        'title' => 'CARRITO VACÍO',
        'message' => 'No hay productos en el carrito.',
        'icon' => 'warning',
    ]);
}


    public function ticket($id)
{
    $venta = Venta::with(['cliente', 'detalleventa.producto'])->find($id);

    if (!$venta) {
        abort(404, 'La venta no fue encontrada.');
    }

    $company = [
        'nombre' => 'INSTITUTO DE ESTUDIO DE BACHILLERATO DE OAXACA',
        'direccion' => 'Dalias 321, Reforma, 68050 Oaxaca de Juárez, Oax.',
        'telefono' => '951 518 6601',
    ];

    // Generar el PDF
    $pdf = PDF::loadView('ventas.ticket', [
        'venta' => $venta,
        'productos' => $venta->detalleventa,
        'fecha' => now()->format('d/m/Y'),
        'hora' => now()->format('H:i:s'),
        'company' => $company,
    ]);
    return $pdf->stream("ticket_venta_{$id}.pdf");

}


    public function show()
{
    $ventas = Venta::all(); // Cargar todas las ventas
    return view('venta.show', compact('ventas'));
}


    public function cliente(Request $request)
    {
        $term = $request->get('term');
        $clients = Cliente::where('nombre', 'LIKE', '%' . $term . '%')
            ->select('id', 'nombre AS label', 'telefono', 'direccion')
            ->limit(10)
            ->get();
        return response()->json($clients);
    }

    public function edit($id)
    {
        $venta = Venta::with('detalleventa.producto', 'cliente')->findOrFail($id);
        return view('ventas.edit', compact('venta'));
    }

    public function update(Request $request, $id)
    {
        $venta = Venta::findOrFail($id);

        $venta->estado = $request->input('estado', $venta->estado);
        $venta->save();

        foreach ($request->input('productos', []) as $detalleId => $detalleData) {
            $detalle = Detalleventa::findOrFail($detalleId);
            $detalle->cantidad = $detalleData['cantidad'];
            $detalle->precio = $detalleData['precio'];
            $detalle->save();
        }

        return redirect()->route('ventas.detalles', $venta->id)->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy($id)
    {
        $venta = Venta::find($id);
        if ($venta) {
            $venta->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }


    public function detalles($id)
{
    // Carga la venta con sus relaciones necesarias
    $venta = Venta::with(['cliente', 'detalleventa.producto'])->find($id);

    if (!$venta) {
        abort(404, 'La venta no fue encontrada.');
    }

    return view('venta.detalles', compact('venta'));
}
public function create()
{
    return view('venta.create'); // Asegúrate de que esta vista exista
}
public function misPedidos()
{
    $usuarioId = auth()->id();

    // 📌 Ventas realizadas directamente por el CLIENTE (id_usuario = id_cliente)
    $ventasCliente = Venta::where('id_cliente', $usuarioId)
                          ->whereColumn('id_cliente', 'id_usuario') // Asegurar que el cliente hizo la compra
                          ->with(['detalleventa.producto'])
                          ->get();

    // 📌 Ventas realizadas por un ADMINISTRADOR (id_usuario != id_cliente)
    $ventasAdmin = Venta::where('id_cliente', $usuarioId)
                        ->whereColumn('id_cliente', '<>', 'id_usuario') // La compra la hizo un admin
                        ->with(['detalleventa.producto', 'usuario']) // Cargar info del admin
                        ->get();

    return view('carrito.pedidos', compact('ventasCliente', 'ventasAdmin'));
}


public function cambiarEstado(Request $request, $id)
{
    $request->validate([
        'estado' => 'required|in:pendiente,aprobado,cancelado'
    ]);

    $venta = Venta::findOrFail($id); // Busca la venta o lanza 404 si no existe
    $venta->estado = $request->estado;
    $venta->save();

    return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente.']);
}
public function detallesCliente($id)
{
    $idCliente = Cliente::where('user_id', auth()->id())->value('id');

if (!$idCliente) {
    abort(403, 'No tienes permisos para ver esta venta.');
}

$pedido = Venta::with(['detalleventa.producto'])
    ->where('id_cliente', $idCliente)
    ->findOrFail($id);


    return view('pedidos.detalles_cliente', compact('pedido'));
}


}


