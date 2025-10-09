<?php

namespace Database\Factories;

use App\Models\Contacto;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;


class ContactoFactory extends Factory
{
    protected $model = Contacto::class;

    public function definition(): array
    {
        return [
            'cliente_id' => Cliente::factory(), 
            'telefono' => $this->faker->phoneNumber(), 
            
            // Genera una dirección de correo electrónico única y segura
            'email' => $this->faker->unique()->safeEmail(), 

        ];
    }
}
