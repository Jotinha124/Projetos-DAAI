<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investigador extends Model
{
    public $table = "investigador";
    
    public $fillable = [
        'nome',
        'email',
        'palavrapasse'
    ];
}
