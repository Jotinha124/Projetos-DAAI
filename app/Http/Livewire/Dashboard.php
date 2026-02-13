<?php

namespace App\Http\Livewire;

use App\Models\Projeto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $query = DB::table('projeto');

        if(Session::get('s_idTipoUtilizador') == env('TIPO_INVESTIGADOR')){
            $numProjetos = $query->where('id_investigador', Session::get('s_userId'))->count();
        }elseif(Session::get('s_idTipoUtilizador') == env('TIPO_TECNICO')){
            $numProjetos = $query->count();
        }

        $projetos = $query->where('id_investigador', Session::get('s_userId'))->get();

        $dados = Projeto::select(
            DB::raw("DATE_FORMAT(data, '%Y-%m') as mes"),
            DB::raw("SUM(orcamento) as orcamento")
        )
            ->groupBy('mes')
            ->orderBy('mes', 'ASC')
            ->get();

        $array = [['Mês', 'Orçamento']];
        $array[] = ['2026-01', 0];
        foreach ($dados as $item) {
            $array[] = [$item->mes, (float)$item->orcamento];
        }

        return view('livewire.dashboard',[
            'numProjetos' => $numProjetos,
            'dados' => $array,
            'projetos' => $projetos
        ])->extends('layouts.master');
    }
}
