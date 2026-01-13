<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Exception;
use Illuminate\Http\Request;

class Logs extends Controller
{
    public static function log($id_projeto, $id_tecnico_apoio, $id_status)
    {
        $Log = Log::create([
            'id_projeto' => $id_projeto,
            'id_tecnico_apoio' => $id_tecnico_apoio,
            'id_status' => $id_status,
            'data' => date('Y-m-d H:i:s')
        ]);

        if($Log){
            return true;
        }else{
            return false;
        }
    }
}
