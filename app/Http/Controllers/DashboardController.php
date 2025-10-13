<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Obtener los valores de los filtros
        $estadoFiltro = $request->input('estado', 'pendiente');
        $fechaFiltro = $request->input('fecha_salida');

        $reservasQuery = Reserva::with(['cliente', 'lugar', 'micros.tipoMicro', 'horario']);

        if ($estadoFiltro !== 'todos') {
            $reservasQuery->where('estado', $estadoFiltro);
        }

        if ($fechaFiltro) {
            $reservasQuery->whereHas('horario', function ($query) use ($fechaFiltro) {
                $query->whereDate('fecha_salida', $fechaFiltro);
            });
        }

        $reservas = $reservasQuery->get();

        return view('dashboard', compact('reservas', 'estadoFiltro', 'fechaFiltro'));
    }
}