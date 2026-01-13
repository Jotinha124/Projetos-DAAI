<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public $table = "logs";

    public $fillable = [
        'data',
        'id_projeto',
        'id_tecnico_apoio',
        'id_status'
    ];
}
