<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['nombre','apellido'];

    // Un cliente tiene muchos (hasMany) contactos 
    public function contactos(){
        return $this->hasMany(Contacto::class);
    }

    // Un cliente tiene muchas reservas 
    public function reservas(){
        return $this->hasMany(Reserva::class);
    }
}
