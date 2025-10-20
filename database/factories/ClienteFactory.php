<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Contacto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName(),
            'apellido' => $this->faker->lastName(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Cliente $cliente) {
            // Usa el ContactoFactory para crear 1 contacto para el cliente que acabamos de crear.
            Contacto::factory()
                ->for($cliente) 
                ->create();
        });
    }
}