<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 *
 * @property $id
 * @property $codigo
 * @property $producto
 * @property $precio_compra
 * @property $precio_venta
 * @property $foto
 * @property $stock
 * @property $id_categoria
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Producto extends Model
{
    /**
     * Reglas de validación.
     *
     * @var array
     */
    static $rules = [
        'codigo' => 'required',
        'producto' => 'required',
        'precio_compra' => 'required|numeric',
        'precio_venta' => 'required|numeric',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'stock' => 'required|integer|min:0',
    ];

    /**
     * Configuración de paginación predeterminada.
     *
     * @var int
     */
    protected $perPage = 20;

    /**
     * Atributos asignables masivamente.
     *
     * @var array
     */
    protected $fillable = ['codigo', 'producto', 'precio_compra', 'precio_venta', 'foto', 'stock', 'id_categoria'];

    /**
     * Relación con la categoría.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    /**
     * Relación con los detalles de venta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalleventa()
    {
        return $this->hasMany(Detalleventa::class, 'id_producto');
    }
    public function ventas()
{
    return $this->belongsToMany(Venta::class, 'venta_producto', 'id_producto', 'id_venta')
                ->withPivot('cantidad', 'precio_unitario')
                ->withTimestamps();
}

public function setStockAttribute($value)
{
    $this->attributes['stock'] = max(0, (int) $value);
}



}
