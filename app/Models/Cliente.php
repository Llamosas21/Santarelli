<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

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
