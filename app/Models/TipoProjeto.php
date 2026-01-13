<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoProjeto extends Model
{
    public $table = "tipo_projeto";
    
    public $fillable = [
        'nome'
    ];
}
