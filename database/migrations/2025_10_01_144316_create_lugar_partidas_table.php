<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLugarPartidasTable extends Migration
{
    public function up()
    {
        Schema::create('lugar_partidas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); 
            $table->string('direccion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lugar_partidas');
    }
}