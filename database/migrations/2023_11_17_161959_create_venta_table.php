<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 10, 2);
            $table->unsignedBigInteger('id_cliente')->nullable(); // Cliente puede ser NULL
            $table->enum('estado', ['pendiente', 'aprobado', 'cancelado'])->default('pendiente');
            $table->timestamps();
        
            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
