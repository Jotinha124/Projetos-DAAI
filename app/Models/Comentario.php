<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    public $table = "comentario";
    
    public $fillable = [
        'id_projeto',
        'id_user',
        'comentario',
        'data'
    ];
}
