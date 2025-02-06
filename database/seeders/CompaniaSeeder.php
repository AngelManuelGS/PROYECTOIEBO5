<?php

namespace Database\Seeders;

use App\Models\Compania;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompaniaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Compania::create([
            'nombre' => 'SISTEMAS',
            'correo' => 'sistemasfo@gmail.com',
            'telefono' => '0000000000',
            'direccion' => 'México',
        ]);
    }
}
