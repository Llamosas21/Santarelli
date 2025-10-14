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

    public function resumen(): View
    {
        $inicioMes = now()->startOfMonth();
        $finMes = now()->endOfMonth();

        $reservas = Reserva::query()
            ->with(['cliente', 'lugar', 'micros.tipoMicro', 'horario'])
            // Une directamente con 'horario_reserva' porque ahí está la fecha
            ->join('horario_reserva', 'reservas.id', '=', 'horario_reserva.reserva_id')
            // Filtra por la fecha de salida que está en esa tabla
            ->whereBetween('horario_reserva.fecha_salida', [$inicioMes, $finMes])
            // Ordena por la fecha de salida para ver las más próximas primero
            ->orderBy('horario_reserva.fecha_salida', 'asc')
            // Selecciona solo los campos de la tabla reservas para evitar conflictos
            ->select('reservas.*')
            // Evita posibles duplicados generados por el 'join'
            ->distinct()
            ->get();

        return view('resumen', compact('reservas'));
    }
}