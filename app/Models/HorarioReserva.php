<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HorarioReserva extends Model
{
    use HasFactory;

    protected $table = 'horario_reserva';
    protected $fillable = ['reserva_id', 'fecha_salida', 'fecha_regreso'];

    // Un horario pertenece a una reserva
    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }
}
