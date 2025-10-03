<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoMicro extends Model
{
    use HasFactory;

    protected $table = 'tipos_micros';
    protected $fillable = ['nombre', 'capacidad', 'precio_base', 'estado'];

    public function microsReserva()
    {
        return $this->hasMany(MicroReserva::class);     
    }
}

