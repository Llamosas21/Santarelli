<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LugarDestino extends Model
{
    use HasFactory;

    protected $table = 'lugares_destino';
    protected $fillable = ['nombre', 'direccion'];
}
