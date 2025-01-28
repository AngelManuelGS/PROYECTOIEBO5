<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            if (!Schema::hasColumn('productos', 'codigo')) {
                $table->string('codigo')->unique()->after('id'); // Código único del producto
            }

            if (!Schema::hasColumn('productos', 'producto')) {
                $table->string('producto')->after('codigo'); // Nombre del producto
            }

            if (!Schema::hasColumn('productos', 'precio_compra')) {
                $table->decimal('precio_compra', 8, 2)->after('producto'); // Precio de compra
            }

            if (!Schema::hasColumn('productos', 'precio_venta')) {
                $table->decimal('precio_venta', 8, 2)->after('precio_compra'); // Precio de venta
            }

            if (!Schema::hasColumn('productos', 'foto')) {
                $table->string('foto')->nullable()->after('precio_venta'); // Ruta de la imagen (puede ser nulo)
            }

            if (!Schema::hasColumn('productos', 'id_categoria')) {
                $table->unsignedBigInteger('id_categoria')->after('foto'); // Relación con la tabla categorías
            }

            if (!Schema::hasColumn('productos', 'stock')) {
                $table->integer('stock')->default(0)->after('id_categoria'); // Stock inicial, por defecto 0
            }

            // Agregar clave foránea si no existe
            if (!Schema::hasColumn('productos', 'id_categoria')) {
                $table->foreign('id_categoria')->references('id')->on('categorias')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            // Eliminar clave foránea solo si existe
            if (Schema::hasColumn('productos', 'id_categoria')) {
                $table->dropForeign(['id_categoria']);
            }

            // Eliminar columnas solo si existen
            if (Schema::hasColumn('productos', 'codigo')) {
                $table->dropColumn('codigo');
            }
            if (Schema::hasColumn('productos', 'producto')) {
                $table->dropColumn('producto');
            }
            if (Schema::hasColumn('productos', 'precio_compra')) {
                $table->dropColumn('precio_compra');
            }
            if (Schema::hasColumn('productos', 'precio_venta')) {
                $table->dropColumn('precio_venta');
            }
            if (Schema::hasColumn('productos', 'foto')) {
                $table->dropColumn('foto');
            }
            if (Schema::hasColumn('productos', 'id_categoria')) {
                $table->dropColumn('id_categoria');
            }
            if (Schema::hasColumn('productos', 'stock')) {
                $table->dropColumn('stock');
            }
        });
    }
};
