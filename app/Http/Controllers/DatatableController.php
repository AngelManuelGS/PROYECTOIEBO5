<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Venta;
use Yajra\DataTables\Facades\DataTables;

class DatatableController extends Controller
{
    public function products()
    {
        $products = Producto::select('id', 'codigo', 'producto', 'precio_compra', 'precio_venta', 'foto')
            ->orderBy('id', 'desc')->get();
        return DataTables::of($products)->toJson();
    }

    public function clients()
    {
        $clientes = Cliente::with('user')->select(['id', 'nombre', 'email', 'telefono', 'direccion', 'plante_educativo', 'region']);
        return datatables()->of($clientes)
            ->addColumn('user.email', function ($cliente) {
                return $cliente->user ? $cliente->user->email : 'Sin correo';
            })
            ->toJson();
    }



    public function users()
    {
        $users = User::select('id', 'name', 'email')
            ->orderBy('id', 'desc')->get();
        return DataTables::of($users)->toJson();
    }

    public function categories()
    {
        $categories = Categoria::select('id', 'nombre')
            ->orderBy('id', 'desc')->get();
        return DataTables::of($categories)->toJson();
    }

    public function sales()
    {
        $sales = Venta::join('clientes', 'ventas.id_cliente', '=', 'clientes.id')
            ->select('ventas.*', 'clientes.nombre')
            ->orderBy('ventas.id', 'desc')->get();
        return DataTables::of($sales)->toJson();
    }
    public function list()
{
    $clientes = Cliente::with('user')->get(); // Carga la relación `user`
    return response()->json(['data' => $clientes]);
}

}
