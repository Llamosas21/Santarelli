<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LugarPartida extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'direccion'];

    /**
     * Un lugar de partida puede tener muchas reservas.
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'lugar_partida_id');
    }
}