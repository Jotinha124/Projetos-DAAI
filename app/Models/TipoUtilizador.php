<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoUtilizador extends Model
{
    public $table = "tipo_utilizador";
    
    public $fillable = [
        'tipo_utilizador'
    ];
}
