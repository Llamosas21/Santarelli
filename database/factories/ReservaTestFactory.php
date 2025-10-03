<?php
// Este archivo queda en Sin Utilidad es solo una referencia.

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReservaTestFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cliente' => $this->faker->name(),
            'destino' => $this->faker->city(),
            'tipo_micro' => $this->faker->randomElement(['20 personas', '40 personas', '60 personas']),
            'cantidad_micros' => $this->faker->numberBetween(1, 7),
            'monto' => $this->faker->numberBetween(20000, 50000),
            'estado' => $this->faker->randomElement(['pendiente', 'aceptado', 'rechazado']),
        ];
    }
}
