<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    /**
     * Reglas de validación para el modelo Cliente.
     * Estas reglas pueden ser útiles si se utilizan en validaciones personalizadas.
     */
    static $rules = [
        'nombre' => 'required|string|max:255', // El nombre es obligatorio y debe ser una cadena de texto con un máximo de 255 caracteres
        'telefono' => 'required|string|max:15', // El teléfono es obligatorio y puede contener un máximo de 15 caracteres
        'direccion' => 'required|string|max:255', // La dirección es obligatoria y tiene un límite de 255 caracteres
        'id_usuario' => 'required|integer|exists:users,id', // Clave foránea que debe coincidir con un ID en la tabla 'users'
        'plante_educativo' => 'nullable|string|max:255', // Campo opcional para plantel educativo
        'region' => 'nullable|string|max:255', // Campo opcional para región
    ];

    /**
     * Atributos que se pueden asignar de forma masiva.
     */
    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'direccion',
        'user_id', // Relación con el usuario (clave foránea)
        'plante_educativo',
        'region',
    ];

    /**
     * Relación con el modelo User.
     * Un cliente pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Define la relación belongsTo con el modelo User
    }
}
