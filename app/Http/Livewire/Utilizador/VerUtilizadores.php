<?php

namespace App\Http\Livewire\Utilizador;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class VerUtilizadores extends Component
{
    public function apagarUtilizador($id)
    {
        User::find($id)->delete();
        session()->flash('mensagem','Utilizador apagado com sucesso');
    }

    public function resetarPassword($id)
    {
        $Utilizador = User::find($id);

        //ENVIAR EMAIL
    }

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
