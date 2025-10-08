<?php

namespace Database\Factories;

use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\LugarDestino;
use App\Models\TipoMicro;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservaFactory extends Factory
{
    protected $model = Reserva::class;

    public function definition(): array
    {
        return [
            'cliente_id' => Cliente::factory(),
            'lugar_id' => LugarDestino::factory(),
            'monto' => $this->faker->numberBetween(300000, 1500000),
            'cantidad_pasajeros' => $this->faker->numberBetween(2, 20) * 10,
            'estado' => $this->faker->randomElement(['pendiente', 'aceptado', 'rechazado'])
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Reserva $reserva) {
            // Crear el horario de la reserva
            $fechaSalida = $this->faker->dateTimeBetween('now', '+2 months');
            $fechaRegreso = $this->faker->dateTimeBetween(
                $fechaSalida->format('Y-m-d'),
                $fechaSalida->modify('+1 month')->format('Y-m-d')
            );
            
            $reserva->horario()->create([
                'fecha_salida' => $fechaSalida,
                'fecha_regreso' => $fechaRegreso
            ]);

            // Crear la relación con el micro
            // Primero creamos el tipo de micro
            $tipoMicro = TipoMicro::factory()->create();

            // Luego lo asociamos a la reserva
            $reserva->micros()->create([
                'tipo_micro_id' => $tipoMicro->id,
                'cantidad' => 1
            ]);
        });
    }
}