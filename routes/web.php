<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ReservaController; 


Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/resumen', [DashboardController::class, 'resumen'])->name('resumen');
  
    //Muestra información detallada de un cliente específico.
    Route::get('/clientes/{id}', [ClienteController::class, 'show'])->name('clientes.show');

    // Muestra el formulario para editar una reserva. 
    Route::get('/reservas/{reserva}/edit', [ReservaController::class, 'edit'])->name('reservas.edit');
    // Procesa los datos del formulario de edición.
    Route::put('/reservas/{reserva}', [ReservaController::class, 'update'])->name('reservas.update');
});
require __DIR__.'/auth.php';