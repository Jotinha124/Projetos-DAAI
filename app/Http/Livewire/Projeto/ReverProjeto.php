<?php

namespace App\Http\Livewire\Projeto;

use App\Http\Controllers\Logs;
use App\Models\Anexo;
use App\Models\Log;
use App\Models\Projeto;
use App\Services\Operations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ReverProjeto extends Component
{
    public $id;
    public $nomeProjeto;
    public $sumario;
    public $orcamento;
    public $TipoProjeto;
    public $entidadesexternas;
    public $Financiamento;
    public $anexos;

    public $rever = false;

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
        $this->TipoProjeto = $Projeto->id_tipoprojeto;
        $this->entidadesexternas = $Projeto->entidades_externas;
        $this->Financiamento = $Projeto->id_financiamento;

        $this->renderAnexos();
    }

    public function renderAnexos()
    {

        $Anexos = DB::table('anexo')
            ->join('users', 'anexo.id_user', '=', 'users.id')
            ->select('anexo.*', 'users.nome as nome_user')
            ->where('id_projeto', $this->id)->get();

        $this->anexos = $Anexos;
    }

    public function setRever()
    {
        $this->rever = true;
    }

    public function apagarFicheiro($id)
    {
        $Anexo = Anexo::find($id);

        $file = Storage::disk('projetos')->delete($Anexo->anexo);

        if ($file) {
            $Anexo->delete();
            session()->flash('mensagem', 'Ficheiro apagado com sucesso');
            $this->renderAnexos();
        } else {
            session()->flash('mensagem_erro', 'Erro ao apagar ficheiro');
        }
    }

    public function enviarProjeto()
    {
        $Projeto = Projeto::find($this->id)->update([
            'id_status' => env('STATUS_ENVIADO', -1),
        ]);

        Logs::log(
            $this->id,
            Session::get('s_userId'),
            env('STATUS_ENVIADO', -1)
        );

        session()->flash('mensagem', 'Projeto enviado com sucesso');

        return redirect()->route('projetos');
    }

    public function enviar()
    {

        $this->validate([
            'nomeProjeto'   => 'required|string|max:255',
            'sumario'       => 'nullable|string',
            'orcamento'     => 'required|numeric|min:1',
            'TipoProjeto'   => 'required',
            'Financiamento' => 'required',
        ]);

        $Projeto = Projeto::find($this->id);

        $Projeto->update([
            'projeto' => $this->nomeProjeto,
            'sumario' => $this->sumario,
            'orcamento' => $this->orcamento,
            'id_tipoprojeto' => $this->TipoProjeto,
            'entidades_externas' => $this->entidadesexternas,
            'id_financiamento' => $this->Financiamento,
            'id_status' => env('STATUS_ENVIADO', -1),
        ]);

        Logs::log(
            $this->id,
            Session::get('s_userId'),
            env('STATUS_ENVIADO', -1)
        );

        session()->flash('mensagem', 'Projeto enviado com sucesso');

        return redirect()->route('projetos');
    }

    public function render()
    {

        $TipoPorjeto = DB::table('tipo_projeto')->get();

        $Financiamento = DB::table('financiamento')->get();

        return view('livewire.projeto.rever-projeto', [
            'rever' => $this->rever,
            'tipos_projeto' => $TipoPorjeto,
            'financiamento' => $Financiamento
        ])->extends('layouts.master');
    }
}
