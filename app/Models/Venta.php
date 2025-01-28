<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = ['total', 'cliente_id', 'id_usuario', 'estado'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id'); // Asegúrate de que 'cliente_id' sea la clave foránea correcta
    }


    public function detalleventa()
    {
        return $this->hasMany(Detalleventa::class, 'id_venta');
    }
}
