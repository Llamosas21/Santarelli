<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = ['cliente_id', 'lugar_id', 'monto', 'cantidad_pasajeros','estado'];

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
