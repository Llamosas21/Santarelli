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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('institucion_id')->nullable()->constrained('instituciones')->nullOnDelete();
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->nullOnDelete();
            $table->foreignId('lugar_id')->nullable()->constrained('lugares_destino')->nullOnDelete();
            $table->foreignId('tipo_micro_id')->nullable()->constrained('tipos_micros')->nullOnDelete();
            $table->integer('cantidad_micros');
            $table->decimal('monto', 12, 2);
            $table->enum('estado', ['pendiente', 'aceptado', 'rechazado'])->default('pendiente');
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
