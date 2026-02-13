<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusUtilizador extends Model
{
    public $table = "status_utilizador";

    public $fillable = [
        'status'
    ];
}
