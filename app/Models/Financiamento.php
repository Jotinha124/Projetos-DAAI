<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Financiamento extends Model
{
    public $table = "financiamento";
    
    public $fillable = [
        'financiamento',
        'internacional'
    ];
}
