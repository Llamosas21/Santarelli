<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservaTest extends Model
{
    use HasFactory;

    protected $table = 'reservas_table_test'; // muy importante!
    
    protected $fillable = [
        'cliente',
        'destino',
        'tipo_micro',
        'cantidad_micros',
        'monto',
        'estado',
    ];
}
