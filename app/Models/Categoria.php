<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    /**
     * Validaciones para el modelo.
     */
    static $rules = [
        'nombre' => 'required|string|max:255',
        'anio' => 'required|integer|min:1900|max:2100', // Validación para el año
        'ciclo' => 'required|string|in:A,B',           // Validación para el ciclo escolar (A o B)
    ];

    /**
     * Nombre de la tabla asociada al modelo.
     */
    protected $table = 'categorias';

    /**
     * Campos asignables de forma masiva.
     */
    protected $fillable = ['nombre', 'anio', 'ciclo'];

    /**
     * Relación: Una categoría tiene muchos productos.
     */
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
