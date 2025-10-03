<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MicroReserva extends Model
{
    use HasFactory;

    protected $table = 'micro_reserva';
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
