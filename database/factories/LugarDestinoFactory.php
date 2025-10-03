<?php

namespace Database\Factories;

use App\Models\LugarDestino;
use Illuminate\Database\Eloquent\Factories\Factory;

class LugarDestinoFactory extends Factory
{
    
    protected $model = LugarDestino::class;

    public function definition(): array
    {
        // Lista de lugares en Buenos Aires con su respectiva dirección.
        $lugaresCuriososBA = [
            'Museo Benito Quinquela Martín' => 'Avenida Don Pedro de Mendoza 1835, CABA',
            'Manzana de las Luces' => 'Perú 272, CABA',
            'Palacio Barolo' => 'Avenida de Mayo 1370, CABA',
            'Cementerio de la Chacarita' => 'Avenida Guzmán 680, CABA',
            'Jardín Japonés' => 'Av. Casares 3450, CABA',
            'El Zanjón de Granados' => 'Defensa 755, CABA',
        ];

        // Selecciona una clave (nombre del lugar) de forma aleatoria.
        $nombreLugar = $this->faker->randomElement(array_keys($lugaresCuriososBA));
        // Usa la clave seleccionada para obtener la dirección correspondiente.
        $direccionLugar = $lugaresCuriososBA[$nombreLugar];

        // Se retorna el nombre y la dirección seleccionados.
        return [
            'nombre' => $nombreLugar,
            'direccion' => $direccionLugar,
        ];
    }
}
