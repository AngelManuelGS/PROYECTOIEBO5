<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    public function run()
    {
        // Datos de clientes de ejemplo
        $clientes = [
            ['nombre' => 'Juan Pérez', 'email' => 'juan@gmail.com', 'telefono' => '5551234567', 'direccion' => 'Calle 1, Ciudad A', 'plante_educativo' => 'Universidad ABC', 'region' => 'Centro'],
            ['nombre' => 'María Gómez', 'email' => 'maria.gomez@example.com', 'telefono' => '5559876543', 'direccion' => 'Calle 2, Ciudad B', 'plante_educativo' => 'Instituto XYZ', 'region' => 'Norte'],
            ['nombre' => 'Carlos Ramírez', 'email' => 'carlos.ramirez@example.com', 'telefono' => '5555555555', 'direccion' => 'Calle 3, Ciudad C', 'plante_educativo' => 'Colegio 123', 'region' => 'Sur'],
            ['nombre' => 'Ana López', 'email' => 'ana.lopez@example.com', 'telefono' => '5554443333', 'direccion' => 'Calle 4, Ciudad D', 'plante_educativo' => 'Escuela Nacional', 'region' => 'Este'],
            ['nombre' => 'Luis Torres', 'email' => 'luis.torres@example.com', 'telefono' => '5552221111', 'direccion' => 'Calle 5, Ciudad E', 'plante_educativo' => 'Universidad DEF', 'region' => 'Oeste'],
        ];

        foreach ($clientes as $cliente) {
            // Crear usuario en la tabla `users`
            $user = User::create([
                'name' => $cliente['nombre'],
                'email' => $cliente['email'],
                'password' => Hash::make('password123'), // Contraseña por defecto
                'role' => 'cliente',
            ]);

            // Crear cliente asociado en la tabla `clientes`
            Cliente::create([
                'user_id' => $user->id,
                'nombre' => $cliente['nombre'],
                'email' => $cliente['email'],
                'telefono' => $cliente['telefono'],
                'direccion' => $cliente['direccion'],
                'plante_educativo' => $cliente['plante_educativo'],
                'region' => $cliente['region'],
            ]);
        }
    }
}
