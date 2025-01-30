<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductoVentaController extends Controller
{
    public function index()
    {
        return view('productosVenta.index'); // Asegúrate de que esta vista existe
    }
}
