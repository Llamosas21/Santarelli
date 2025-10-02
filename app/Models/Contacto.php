<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $fillable = ['cliente_id', 'telefono', 'email'];

    public function cliente (){
        return $this->belongsTo(Cliente::class, 'lugar_id'); // Se pasa lugar_id ya que laravel sino buscaria ugar_destino_id por convención
    }
}
