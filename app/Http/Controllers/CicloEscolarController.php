<?php

namespace App\Http\Controllers;

use App\Models\CicloEscolar;
use Illuminate\Http\Request;

class CicloEscolarController extends Controller
{
    public function index()
    {
        $ciclos = CicloEscolar::all();
        return view('cicloescolar.index', compact('ciclos'));
    }

    public function create()
    {
        return view('cicloescolar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'anio' => 'required|string|max:4',
            'ciclo' => 'required|in:A,B',
        ]);

        CicloEscolar::create($request->all());

        return redirect()->route('cicloescolar.index')->with('success', 'Ciclo Escolar creado con éxito.');
    }

    public function edit(CicloEscolar $cicloEscolar)
    {
        return view('cicloescolar.edit', compact('cicloEscolar'));
    }

    public function update(Request $request, CicloEscolar $cicloEscolar)
    {
        $request->validate([
            'anio' => 'required|string|max:4',
            'ciclo' => 'required|in:A,B',
        ]);

        $cicloEscolar->update($request->all());

        return redirect()->route('cicloescolar.index')->with('success', 'Ciclo Escolar actualizado con éxito.');
    }

    public function destroy(CicloEscolar $cicloEscolar)
    {
        $cicloEscolar->delete();

        return redirect()->route('cicloescolar.index')->with('success', 'Ciclo Escolar eliminado con éxito.');
    }
}
