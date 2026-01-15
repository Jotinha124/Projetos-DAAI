<?php

namespace App\Http\Livewire\Utilizador;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class VerUtilizadores extends Component
{
    public function render()
    {
        $Utilizadores = DB::table('users')
            ->join('tipo_utilizador', 'users.id_tipo_utilizador', '=', 'tipo_utilizador.id')
            ->select('users.*', 'tipo_utilizador.tipo_utilizador as tipo_utilizador')
            ->get();

        return view('livewire.utilizador.ver-utilizadores', [
            'Utilizadores' => $Utilizadores
        ])->extends('layouts.master');
    }
}
