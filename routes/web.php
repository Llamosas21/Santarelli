<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ReservaController; 
use App\Http\Controllers\Api\ReservaApiController;
use App\Models\Reserva;

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
    
    // Esta API interna (segura) revisará el conteo de reservas.
        Route::get('/api/reservas/count', function() {
            return response()->json(['count' => Reserva::count()]);
        })->name('api.reservas.count');
});
require __DIR__.'/auth.php';

// Esta ruta es pública y NO requiere autenticación.
Route::post('/api/reservas', [ReservaApiController::class, 'store'])->name('api.reservas.store');