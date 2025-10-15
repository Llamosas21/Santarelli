<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\LugarDestino; 
use App\Models\TipoMicro;   
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Importar DB para usar transacciones
use Illuminate\Support\Facades\Redirect;
use Throwable; // Para manejar posibles errores en la transacción

class ReservaController extends Controller
{

    public function edit(Reserva $reserva)
    {
        // Carga eficiente de las relaciones necesarias para el formulario
        $reserva->load('lugar', 'horario', 'micros.tipoMicro', 'cliente');

        $lugares = LugarDestino::orderBy('nombre')->get()->unique('nombre');
        $tiposMicro = TipoMicro::where('estado', 'activo')->orderBy('nombre')->get()->unique('nombre');

        return view('edit', compact('reserva', 'lugares', 'tiposMicro'));
    }

    public function update(Request $request, Reserva $reserva)
    {
        $validatedData = $request->validate([
            'lugar_id' => 'required|exists:lugares_destino,id',
            'monto' => 'required|numeric|min:0',
            'estado' => 'required|in:pendiente,aceptado,rechazado',
            'fecha_salida' => 'required|date',
            'fecha_regreso' => 'required|date|after_or_equal:fecha_salida',
            'nuevo_tipo_micro_id' => 'nullable|exists:tipos_micros,id',
            'nueva_cantidad_micro' => 'nullable|integer|min:1|required_with:nuevo_tipo_micro_id',
        ]);

        try {
            DB::transaction(function () use ($validatedData, $reserva) {

                // Actualizamos los datos principales de la reserva
                $reserva->update([
                    'lugar_id' => $validatedData['lugar_id'],
                    'monto' => $validatedData['monto'],
                    'estado' => $validatedData['estado'],
                ]);

                // Actualizamos o creamos el horario asociado a la reserva
                $reserva->horario()->updateOrCreate(
                    ['reserva_id' => $reserva->id],
                    [
                        'fecha_salida' => $validatedData['fecha_salida'],
                        'fecha_regreso' => $validatedData['fecha_regreso'],
                    ]
                );

                // Si se especificó un nuevo micro, lo creamos
                if (!empty($validatedData['nuevo_tipo_micro_id'])) {
                    $reserva->micros()->create([
                        'tipo_micro_id' => $validatedData['nuevo_tipo_micro_id'],
                        'cantidad' => $validatedData['nueva_cantidad_micro'],
                    ]);
                }
            });

        } catch (Throwable $e) {
            // Si algo falla dentro de la transacción, redirigimos hacia atrás con un mensaje de error.
            // En un entorno de producción, también es bueno registrar el error: Log::error($e->getMessage());
            return back()->with('error', 'Ocurrió un error inesperado al actualizar la reserva.');
        }

        // Si todo sale bien, redirigimos con el mensaje de éxito.
        return Redirect::route('clientes.show', $reserva->cliente_id)
                         ->with('success', '¡Reserva actualizada correctamente!');
    }
}