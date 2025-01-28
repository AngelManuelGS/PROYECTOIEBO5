<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            if (!Schema::hasColumn('clientes', 'plante_educativo')) {
                $table->string('plante_educativo')->nullable();
            }
            if (!Schema::hasColumn('clientes', 'region')) {
                $table->string('region')->nullable();
            }
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('plante_educativo');
            $table->dropColumn('region');
        });
    }

};
