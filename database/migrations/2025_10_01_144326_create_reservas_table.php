<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('lugar_id')->constrained('lugares_destino')->onDelete('cascade');
            $table->foreignId('lugar_partida_id')->constrained('lugar_partidas') ->onDelete('cascade');
            $table->integer('cantidad_pasajeros');
            $table->decimal('monto', 12, 2);
            $table->enum('estado', ['pendiente','aceptado','rechazado'])->default('pendiente');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
