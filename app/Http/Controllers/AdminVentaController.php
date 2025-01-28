<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Detalleventa;

use App\Models\Venta;

class AdminVentaController extends Controller
{
    public function index()
{
    // Obtén todas las ventas con cliente y detalles
    $ventas = Venta::with('cliente', 'detalleventa.producto')->get();

    // Retorna las ventas en formato JSON para DataTables
    return response()->json([
        'data' => $ventas,
    ]);
}
public function cambiarEstado(Request $request, $id)
{
    $venta = Venta::find($id);

    if (!$venta) {
        return response()->json(['success' => false, 'error' => 'Venta no encontrada'], 404);
    }

    if (!in_array($request->estado, ['pendiente', 'aprobado', 'cancelado'])) {
        return response()->json(['success' => false, 'error' => 'Estado inválido'], 400);
    }

    $venta->estado = $request->estado;
    $venta->save();

    return response()->json(['success' => true]);
}

public function detalles($id)
{
    $venta = Venta::with(['cliente', 'productos'])->findOrFail($id);

    if (!$venta) {
        abort(404, 'La venta no fue encontrada.');
    }

    return view('venta.detalles', compact('venta'));
}


public function edit($id)
{
    $venta = Venta::with('detalleventa.producto', 'cliente')->findOrFail($id);
    return view('ventas.edit', compact('venta'));
}

public function update(Request $request, $id)
{
    $venta = Venta::findOrFail($id);

    // Actualizar datos generales de la venta
    $venta->estado = $request->input('estado', $venta->estado);
    $venta->save();

    // Actualizar detalles (productos)
    foreach ($request->input('productos', []) as $detalleId => $detalleData) {
        $detalle = Detalleventa::findOrFail($detalleId);
        $detalle->cantidad = $detalleData['cantidad'];
        $detalle->precio = $detalleData['precio'];
        $detalle->save();
    }

    return redirect()->route('ventas.detalles', $venta->id)->with('success', 'Venta actualizada correctamente.');
}


public function ticket($id)
{
    $venta = Venta::with('detalleventa.producto', 'cliente')->findOrFail($id);
    return view('ventas.ticket', compact('venta')); // Asegúrate de crear esta vista
}

public function destroy($id)
{
    $venta = Venta::findOrFail($id);

    // Eliminar los detalles asociados primero
    $venta->detalleventa()->delete();

    // Luego eliminar la venta
    $venta->delete();

    return redirect()->route('ventas.show')->with('success', 'Venta eliminada correctamente.');
}



}
