<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorarioReserva extends Model
{
    protected $fillable = ['reserva_id', 'fecha_salida', 'fecha_regreso'];

    // Un horario pertenece a una reserva
    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }
}
