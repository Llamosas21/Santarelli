<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMicro extends Model
{
    protected $fillable = ['nombre', 'capacidad', 'precio_base', 'estado'];

    public function microsReserva()
    {
        return $this->hasMany(MicroReserva::class);     
    }
}

