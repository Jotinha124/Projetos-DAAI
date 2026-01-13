<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    public $table = "anexo";

    public $fillable = [
        'anexo',
        'id_projeto',
        'data',
        'id_tecnico_apoio'
    ];
}
