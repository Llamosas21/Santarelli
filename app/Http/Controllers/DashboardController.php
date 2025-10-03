<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Traemos reservas junto con sus relaciones necesarias
        $reservas = Reserva::with(['cliente', 'lugar', 'micros.tipoMicro'])->get();

        return view('dashboard', compact('reservas'));
    }
}
