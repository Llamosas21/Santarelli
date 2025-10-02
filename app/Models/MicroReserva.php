<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MicroReserva extends Model
{
    protected $fillable = ['reserva_id', 'tipo_micro_id', 'cantidad'];

    // Pertenece a una reserva
    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

    // Pertenece a un tipo de micro
    public function tipoMicro()
    {
        return $this->belongsTo(TipoMicro::class, 'tipo_micro_id');
    }
}
