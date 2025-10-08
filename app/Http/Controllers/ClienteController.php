<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function show($id)
    {
        // Ajustamos los nombres de las relaciones según tus modelos actuales
        $cliente = Cliente::with([
            'contactos',
            'reservas.lugar',           // antes 'lugarDestino'
            'reservas.horario',
            'reservas.micros.tipoMicro' // antes 'microReserva.tipoMicro'
        ])->findOrFail($id);

        return view('show', compact('cliente'));
    }
}
