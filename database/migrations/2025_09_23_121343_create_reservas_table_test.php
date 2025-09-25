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
        Schema::create('reservas_table_test', function (Blueprint $table) {
             $table->id();
            $table->string('cliente');
            $table->string('destino')->nullable();
            $table->string('tipo_micro');
            $table->integer('cantidad_micros');
            $table->decimal('monto', 12, 2);
            $table->enum('estado', ['pendiente', 'aceptado', 'rechazado'])->default('pendiente');
            $table->timestamps(); // created_at / updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas_table_test');
    }
};
