<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentaProductoTable extends Migration
{
    public function up()
    {
        Schema::create('venta_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_venta')->constrained('ventas')->onDelete('cascade');
            $table->foreignId('id_producto')->constrained('productos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('venta_producto');
    }

};
