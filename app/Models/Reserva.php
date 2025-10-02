<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = ['cliente_id', 'lugar_id', 'monto', 'estado'];

    // Una reserva pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Una reserva pertenece a un lugar
    public function lugar()
    {
        return $this->belongsTo(LugarDestino::class, 'lugar_id');
    }

    // Una reserva tiene un horario
    public function horario()
    {
        return $this->hasOne(HorarioReserva::class);
    }

    // Una reserva puede tener muchos micros
    public function micros()
    {
        return $this->hasMany(MicroReserva::class);
    }
}
