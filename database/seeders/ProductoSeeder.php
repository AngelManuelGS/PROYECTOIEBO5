<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    public function run()
    {
        // Obtener todas las categorías
        $categorias = DB::table('categorias')->pluck('id')->toArray();

        $productos = [
            ['codigo' => 'MAT001', 'producto' => 'Álgebra Básica', 'precio_compra' => 200, 'precio_venta' => 250, 'foto' => '/uploads/portada1.jpg', 'id_categoria' => $categorias[0], 'stock' => 10],
            ['codigo' => 'MAT002', 'producto' => 'Geometría Analítica', 'precio_compra' => 180, 'precio_venta' => 220, 'foto' => '/uploads/portada2.jpg', 'id_categoria' => $categorias[0], 'stock' => 8],
            ['codigo' => 'FIS001', 'producto' => 'Física Cuántica', 'precio_compra' => 250, 'precio_venta' => 300, 'foto' => '/uploads/portada3.jpg', 'id_categoria' => $categorias[1], 'stock' => 6],
            ['codigo' => 'FIS002', 'producto' => 'Dinámica y Cinemática', 'precio_compra' => 190, 'precio_venta' => 240, 'foto' => '/uploads/portada4.jpg', 'id_categoria' => $categorias[1], 'stock' => 7],
            ['codigo' => 'QUI001', 'producto' => 'Química Orgánica', 'precio_compra' => 220, 'precio_venta' => 270, 'foto' => '/uploads/portada5.jpg', 'id_categoria' => $categorias[2], 'stock' => 9],
            ['codigo' => 'QUI002', 'producto' => 'Elementos y Compuestos', 'precio_compra' => 200, 'precio_venta' => 260, 'foto' => '/uploads/portada6.jpg', 'id_categoria' => $categorias[2], 'stock' => 12],
            ['codigo' => 'BIO001', 'producto' => 'Biología Celular', 'precio_compra' => 210, 'precio_venta' => 270, 'foto' => '/uploads/portada7.jpg', 'id_categoria' => $categorias[3], 'stock' => 5],
            ['codigo' => 'BIO002', 'producto' => 'Genética Molecular', 'precio_compra' => 230, 'precio_venta' => 290, 'foto' => '/uploads/portada8.jpg', 'id_categoria' => $categorias[3], 'stock' => 4],
            ['codigo' => 'HIS001', 'producto' => 'Historia Universal', 'precio_compra' => 180, 'precio_venta' => 220, 'foto' => '/uploads/portada9.jpg', 'id_categoria' => $categorias[4], 'stock' => 11],
            ['codigo' => 'HIS002', 'producto' => 'Historia Contemporánea', 'precio_compra' => 190, 'precio_venta' => 230, 'foto' => '/uploads/portada10.jpg', 'id_categoria' => $categorias[4], 'stock' => 6],
            ['codigo' => 'GEO001', 'producto' => 'Atlas Geográfico', 'precio_compra' => 170, 'precio_venta' => 210, 'foto' => '/uploads/portada11.jpg', 'id_categoria' => $categorias[5], 'stock' => 10],
            ['codigo' => 'GEO002', 'producto' => 'Mapas del Mundo', 'precio_compra' => 160, 'precio_venta' => 200, 'foto' => '/uploads/portada12.jpg', 'id_categoria' => $categorias[5], 'stock' => 8],
            ['codigo' => 'LIT001', 'producto' => 'Literatura Clásica', 'precio_compra' => 180, 'precio_venta' => 220, 'foto' => '/uploads/portada13.jpg', 'id_categoria' => $categorias[6], 'stock' => 7],
            ['codigo' => 'LIT002', 'producto' => 'Poesía Contemporánea', 'precio_compra' => 190, 'precio_venta' => 230, 'foto' => '/uploads/portada14.jpg', 'id_categoria' => $categorias[6], 'stock' => 9],
            ['codigo' => 'ING001', 'producto' => 'Curso de Inglés Básico', 'precio_compra' => 150, 'precio_venta' => 190, 'foto' => '/uploads/portada15.jpg', 'id_categoria' => $categorias[7], 'stock' => 12],
            ['codigo' => 'ING002', 'producto' => 'Inglés Intermedio', 'precio_compra' => 170, 'precio_venta' => 210, 'foto' => '/uploads/portada16.jpg', 'id_categoria' => $categorias[7], 'stock' => 5],
            ['codigo' => 'COMP001', 'producto' => 'Fundamentos de Programación', 'precio_compra' => 260, 'precio_venta' => 310, 'foto' => '/uploads/portada17.jpg', 'id_categoria' => $categorias[8], 'stock' => 7],
            ['codigo' => 'COMP002', 'producto' => 'Redes Informáticas', 'precio_compra' => 240, 'precio_venta' => 290, 'foto' => '/uploads/portada18.jpg', 'id_categoria' => $categorias[8], 'stock' => 6],
            ['codigo' => 'ART001', 'producto' => 'Historia del Arte', 'precio_compra' => 190, 'precio_venta' => 240, 'foto' => '/uploads/portada19.jpg', 'id_categoria' => $categorias[9], 'stock' => 10],
        ];

        DB::table('productos')->insert($productos);
    }
}
