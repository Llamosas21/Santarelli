<?php

namespace Database\Factories;
use App\Models\TipoMicro;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoMicroFactory extends Factory {
    protected $model = TipoMicro::class;
    public function definition(): array {
        $tipos = [
            ['nombre' => '20 personas', 'capacidad' => 20, 'precio_base' => 25000.00],
            ['nombre' => '40 personas', 'capacidad' => 40, 'precio_base' => 45000.00],
            ['nombre' => '60 personas', 'capacidad' => 60, 'precio_base' => 60000.00],
        ];
        $tipoSeleccionado = $this->faker->randomElement($tipos);
        return [
            'nombre' => $tipoSeleccionado['nombre'],
            'capacidad' => $tipoSeleccionado['capacidad'],
            'precio_base' => $tipoSeleccionado['precio_base'],
            'estado' => 'activo'
        ];
    }
}