<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Reserva;
use App\Models\TipoMicro;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario de prueba
        User::factory()->create([
            'name' => 'test',
            'email' => 'test@santarelli.com',
            'password' => bcrypt('p')
        ]);

       $tiposDeMicro = collect([
            TipoMicro::factory()->create([
                'nombre' => '20 personas', 
                'capacidad' => 20, 
                'precio_base' => 25000.00
            ]),
            TipoMicro::factory()->create([
                'nombre' => '40 personas', 
                'capacidad' => 40, 
                'precio_base' => 45000.00
            ]),
            TipoMicro::factory()->create([
                'nombre' => '60 personas', 
                'capacidad' => 60, 
                'precio_base' => 60000.00
            ]),
        ]);

        // La lógica para crear reservas y asignar micros sigue igual y funcionará perfecto
        Reserva::factory(50)
            ->create()
            ->each(function (Reserva $reserva) use ($tiposDeMicro) {
                $tipoMicroSeleccionado = $tiposDeMicro->random();
                $cantidadDeMicros = rand(1, 3);

                $reserva->micros()->create([
                    'tipo_micro_id' => $tipoMicroSeleccionado->id,
                    'cantidad' => $cantidadDeMicros,
                ]);
            });
        // \App\Models\ReservaTest::factory(50)->create();
    }
}