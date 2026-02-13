<?php

namespace App\Http\Livewire\Projeto;

use App\Models\Projeto;
use App\Services\Operations;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MeuProjeto extends Component
{
    public $id;
    public $nomeProjeto;
    public $sumario;
    public $orcamento;
    public $tipoProjeto;
    public $anexos;
    public $Financiamento;
    public $entidadesExternas;
    public $equipa;
    public $logs;

    public function mount($id)
    {
        $id = Operations::decryptId($id);

        if(!$id){
            session()->flash('mensagem_erro', 'Projeto não encontrado');

            return redirect()->route('projetos');
        }

        $Projeto = Projeto::find($id);

        if (!$Projeto) {
            session()->flash('mensagem_erro', 'Projeto não encontrado');

            return redirect()->route('projetos');
        }

        $this->id = $id;

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

        //Equipa 
        $Equipa = DB::table('equipa')
            ->join('users', 'equipa.id_user', '=', 'users.id')
            ->select('equipa.*', 'users.nome as nome_user', 'users.email as email_user')
            ->where('id_projeto', $this->id)->get();

        $this->equipa = $Equipa;

        //Logs 
        $Logs = DB::table('logs')
            ->join('users', 'logs.id_user', '=', 'users.id')
            ->join('status', 'logs.id_status', '=', 'status.id')
            ->select('logs.*', 'users.nome as nome_user', 'status.status as logstatus')
            ->where('id_projeto', $this->id)->get();

        $this->logs = $Logs;
    }

    public function render()
    {
        return view('livewire.projeto.meu-projeto')->extends('layouts.master');
    }
}
