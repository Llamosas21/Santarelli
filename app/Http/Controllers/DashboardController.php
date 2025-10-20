<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

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

    public function resumen(Request $request): View
    {
        $inicioMes = now()->startOfMonth();
        $finMes = now()->endOfMonth();

        $estadoFiltro = $request->input('estado', 'todos');

        $reservasQuery = Reserva::query()
            ->with(['cliente', 'lugar', 'micros.tipoMicro', 'horario'])
            ->join('horario_reserva', 'reservas.id', '=', 'horario_reserva.reserva_id')
            ->whereBetween('horario_reserva.fecha_salida', [$inicioMes, $finMes])
            ->orderBy('horario_reserva.fecha_salida', 'asc')
            ->select('reservas.*')
            ->distinct();

        if ($estadoFiltro !== 'todos') {
            $reservasQuery->where('reservas.estado', $estadoFiltro);
        }

        $reservas = $reservasQuery->get();

        return view('resumen', compact('reservas', 'estadoFiltro'));
    }

}