<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Obtener el parámetro 'estado' de la URL. Por defecto es 'todos'.
        $estadoFiltro = $request->get('estado', 'todos');

        // Comenzar la consulta con las relaciones necesarias
        $reservasQuery = Reserva::with(['cliente', 'lugar', 'micros.tipoMicro']);

        // Aplicar el filtro si el estado no es 'todos'
        if ($estadoFiltro !== 'todos') {
            
            // Usamos where() para filtrar por el estado de la columna 'estado'
            $reservasQuery->where('estado', $estadoFiltro);
        }

        // Ejecutar la consulta y obtener las reservas
        $reservas = $reservasQuery->get();

        // Pasamos el estado de filtro actual a la vista para que el selector sepa qué opción mostrar.
        return view('dashboard', compact('reservas', 'estadoFiltro'));
    }
}