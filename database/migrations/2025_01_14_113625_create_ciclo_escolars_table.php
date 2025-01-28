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
        Schema::create('ciclo_escolars', function (Blueprint $table) {
            $table->id();
            $table->string('anio'); // Año del ciclo escolar
            $table->enum('ciclo', ['A', 'B']); // Ciclo A/B
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciclo_escolars');
    }
};
