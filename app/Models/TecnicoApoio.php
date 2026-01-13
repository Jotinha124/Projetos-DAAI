<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TecnicoApoio extends Model
{
    public $table = "tecnico_apoio";
    
    public $fillable = [
        'nome',
        'email',
        'palavrapasse',
        'admin'
    ];
}
