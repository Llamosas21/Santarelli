<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contacto extends Model
{
    use HasFactory;
    
    protected $table = 'contactos';
    protected $fillable = ['cliente_id', 'telefono', 'email'];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
}
