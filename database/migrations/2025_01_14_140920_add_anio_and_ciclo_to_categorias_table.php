<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('categorias', function (Blueprint $table) {
            if (!Schema::hasColumn('categorias', 'anio')) {
                $table->integer('anio')->after('nombre')->nullable(false);
            }
            if (!Schema::hasColumn('categorias', 'ciclo')) {
                $table->string('ciclo', 1)->after('anio');
            }
        });
    }

    public function down()
    {
        Schema::table('categorias', function (Blueprint $table) {
            $table->dropColumn(['anio', 'ciclo']);
        });
    }
};
