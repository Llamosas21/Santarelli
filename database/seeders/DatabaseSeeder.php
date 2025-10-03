<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Reserva;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario test
        User::factory()->create([
            'name' => 'test',
            'email' => 'test@santarelli.com',
            'password' => bcrypt('p')
        ]);

        // Crear 10 reservas con sus relaciones
        Reserva::factory(50)->create();
        
        // Comentamos el seeder anterior de prueba
        // \App\Models\ReservaTest::factory(50)->create();
    }
}
