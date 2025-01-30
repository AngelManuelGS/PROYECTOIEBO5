<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            ['nombre' => 'Matemáticas', 'anio' => 1, 'ciclo' => 'A'],
            ['nombre' => 'Física', 'anio' => 1, 'ciclo' => 'B'],
            ['nombre' => 'Química', 'anio' => 2, 'ciclo' => 'A'],
            ['nombre' => 'Biología', 'anio' => 2, 'ciclo' => 'B'],
            ['nombre' => 'Historia', 'anio' => 3, 'ciclo' => 'A'],
            ['nombre' => 'Geografía', 'anio' => 3, 'ciclo' => 'B'],
            ['nombre' => 'Literatura', 'anio' => 4, 'ciclo' => 'A'],
            ['nombre' => 'Inglés', 'anio' => 4, 'ciclo' => 'B'],
            ['nombre' => 'Computación', 'anio' => 5, 'ciclo' => 'A'],
            ['nombre' => 'Arte', 'anio' => 5, 'ciclo' => 'B'],
        ];

        DB::table('categorias')->insert($categorias);
    }
}
