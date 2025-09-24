<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReservaTestFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cliente' => $this->faker->name(),
            'lugar' => $this->faker->city(),
            'tipo_micro' => $this->faker->randomElement(['20 pers', '40 pers', '60 pers']),
            'cantidad_micros' => $this->faker->numberBetween(1, 7),
            'monto' => $this->faker->numberBetween(20000, 50000),
            'estado' => $this->faker->randomElement(['pendiente', 'aceptado', 'rechazado']),
        ];
    }
}
