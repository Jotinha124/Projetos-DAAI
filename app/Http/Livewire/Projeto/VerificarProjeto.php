<?php

namespace App\Http\Livewire\Projeto;

use App\Http\Controllers\Logs;
use App\Models\Financiamento;
use App\Models\Projeto;
use App\Models\TipoProjeto;
use App\Services\Operations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class VerificarProjeto extends Component
{
    public $id;
    public $nomeProjeto;
    public $sumario;
    public $orcamento;
    public $tipoProjeto;
    public $anexos;
    public $Financiamento;
    public $entidadesExternas;

    public function mount($id)
    {
        $id = Operations::decryptId($id);

        $this->id = $id;

        $Projeto = Projeto::find($id);

        if (!$Projeto) {
            session()->flash('mensagem_erro', 'Projeto não encontrado');

            return redirect()->route('projetos');
        }

        $this->nomeProjeto = $Projeto->projeto;
        $this->sumario = $Projeto->sumario;
        $this->orcamento = $Projeto->orcamento;

        $tipoProjeto = DB::table('tipo_projeto')
            ->where('id', $Projeto->id_tipoprojeto)
            ->first();

        $Financiamento = DB::table('financiamento')
            ->where('id', $Projeto->id_financiamento)
            ->first();

        $this->tipoProjeto = $tipoProjeto->tipoprojeto;
        $this->Financiamento = $Financiamento->financiamento;

        $this->entidadesExternas = $Projeto->entidadesexternas;

        //Anexos
        $Anexos = DB::table('anexo')
            ->join('users', 'anexo.id_user', '=', 'users.id')
            ->select('anexo.*', 'users.nome as nome_user')
            ->where('id_projeto', $this->id)->get();

        $this->anexos = $Anexos;
    }

    public function verificar()
    {
        $Projeto = Projeto::find($this->id);

        $Projeto->update([
            'verificado' => 1,
            'id_status' => env('STATUS_AUTORIZACAO', -1),
        ]);

        Logs::log(
            $this->id,
            Session::get('s_userId'),
            env('STATUS_AUTORIZACAO', -1)
        );

        //ENVIAR EMAIL AO INVESTIGADOR

        session()->flash('mensagem', 'Projeto verificado com sucesso');

        return redirect()->route('projetos');
    }

    public function render()
    {
        return view('livewire.projeto.verificar-projeto')->extends('layouts.master');
    }
}
