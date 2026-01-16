<?php

namespace App\Http\Livewire\Projeto;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class VerProjeto extends Component
{
    public function render()
    {
        $Projetos = DB::table('projeto')
            ->join('tipo_projeto', 'projeto.id_tipoprojeto', '=', 'tipo_projeto.id')
            ->join('users as investigador', 'projeto.id_investigador', '=', 'investigador.id')
            ->join('financiamento', 'projeto.id_financiamento', '=', 'financiamento.id')
            ->join('status', 'projeto.id_status', '=', 'status.id')
            ->join('users as tecnico', 'projeto.id_tecnico_apoio', '=', 'tecnico.id')
            ->select(
                'projeto.*',
            'tipo_projeto.tipoprojeto as tipo_projeto',
                'investigador.nome as nome_investigador',
                'financiamento.financiamento as financiamento',
                'status.status as status',
                'tecnico.nome as nome_tecnico_apoio'
            )
            ->get();



        return view('livewire.projeto.ver-projeto',[
            'projetos' => $Projetos
        ])->extends('layouts.master');
    }
}
