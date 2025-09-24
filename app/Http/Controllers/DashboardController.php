<?php

namespace App\Http\Controllers;

use App\Models\ReservaTest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $reservas = ReservaTest::all();
        return view('dashboard', compact('reservas'));
    }
}
