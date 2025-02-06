<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ventas', function (Blueprint $table) {
            // Agregar la clave foránea si no existe
            if (!Schema::hasColumn('ventas', 'id_cliente')) {
                $table->bigInteger('id_cliente')->unsigned()->nullable();
            }
            Schema::table('ventas', function (Blueprint $table) {
                $table->dropForeign(['id_cliente']);
            });


            //$table->foreign('id_cliente')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('cascade');

        });
    }

    public function down()
{
    Schema::table('ventas', function (Blueprint $table) {
        if (Schema::hasColumn('ventas', 'id_cliente')) {
            try {
                $table->dropForeign(['id_cliente']);
            } catch (\Exception $e) {
                // La clave foránea no existe, no hacer nada
            }
            $table->dropColumn('id_cliente');
        }
    });
    }
};
