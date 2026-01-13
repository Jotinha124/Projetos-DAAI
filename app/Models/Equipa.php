<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipa extends Model
{
    public $table = "equipa";
    
    public $fillable = [
        'id_projeto',
        'id_investigador'
    ];
}
