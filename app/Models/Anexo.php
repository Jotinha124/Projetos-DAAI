<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    public $table = "anexo";

    public $fillable = [
        'nome_anexo',
        'anexo',
        'id_projeto',
        'data',
        'id_user'
    ];
}
