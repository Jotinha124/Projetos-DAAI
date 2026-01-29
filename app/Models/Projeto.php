<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    public $table = "projeto";
    
    public $fillable = [
        'projeto',
        'verificado',
        'sumario',
        'orcamento',
        'verificadopresidencia',
        'id_investigador',
        'id_financiamento',
        'id_tecnico_apoio',
        'id_status',
        'id_tipoprojeto',
        'entidadesexternas',
        'data',
        'data_decisao',
        'data_fecho'
    ];
}
