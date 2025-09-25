<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {
            Schema::create('instituciones', function (Blueprint $table) {
                $table->id(); // unsignedBigInteger auto
                $table->string('nombre', 150);
                $table->string('direccion', 200)->nullable();
                $table->string('contacto', 100)->nullable();
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('instituciones');
        }
    };
