<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Muestra los detalles de un cliente y sus reservas.
     */
    public function show($id)
    {
        $cliente = Cliente::with([
            'contactos',
            'reservas.lugar',
            'reservas.horario',
            'reservas.micros.tipoMicro'
        ])->findOrFail($id);


        foreach ($cliente->reservas as $reserva) {
            $reserva->microsAgrupados = $reserva->micros
                ->groupBy('tipo_micro_id') // Agrupamos por el tipo de micro
                ->map(function ($group) {
                    $first = $group->first(); 
                    return (object) [
                        'tipoMicro' => $first->tipoMicro,
                        'cantidad' => $group->sum('cantidad'), // Sumamos la cantidad de todos los micros del mismo tipo
                    ];
                });
        }
        return view('show', compact('cliente'));
    }
}