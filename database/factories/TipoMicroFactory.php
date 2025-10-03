<?php

namespace Database\Factories;

use App\Models\TipoMicro;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoMicroFactory extends Factory
{
    protected $model = TipoMicro::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->randomElement(['20 personas', '40 personas', '60 personas']),
            'capacidad' => 20,
            'precio_base' => 25000.00,
            'estado' => 'activo'
        ];
    }
}