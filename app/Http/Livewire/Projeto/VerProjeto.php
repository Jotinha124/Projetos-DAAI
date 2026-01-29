<?php

namespace App\Http\Livewire\Projeto;

use App\Http\Controllers\Logs;
use App\Http\Controllers\SendEmail;
use App\Models\Projeto;
use App\Services\Operations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class VerProjeto extends Component
{
    public $id;
    public $NomeProjeto;
    public $Sumario;
    public $Orcamento;
    public $tipoProjeto;
    public $Financiamento;
    public $entidadesExternas;
    public $Tecnico;

    public function atribuirTecnico($id)
    {
        $this->dispatch('open-modal');
        $id = Operations::decryptId($id);

        $this->id = $id;

        $Projeto = Projeto::find($id);

        if (!$Projeto) {
            session()->flash('mensagem_erro', 'Projeto não encontrado');

            return redirect()->route('projetos');
        }

        $this->NomeProjeto = $Projeto->projeto;
        $this->Sumario = $Projeto->sumario;
        $this->Orcamento = $Projeto->orcamento;

        $tipoProjeto = DB::table('tipo_projeto')
            ->where('id', $Projeto->id_tipoprojeto)
            ->first();

        $Financiamento = DB::table('financiamento')
            ->where('id', $Projeto->id_financiamento)
            ->first();

        $this->tipoProjeto = $tipoProjeto->tipoprojeto;
        $this->Financiamento = $Financiamento->financiamento;

        $this->entidadesExternas = $Projeto->entidadesexternas;
    }

    public function addTecnico($id)
    {
        $this->validate(
            [
                'Tecnico' => 'required',
            ],
            [
                'Tecnico.required' => 'O campo Técnico de Apoio é obrigatório.',
            ]
        );
        $id = Operations::decryptId($id);

        $Projeto = Projeto::find($id);

        if (!$Projeto) {
            session()->flash('mensagem_erro', 'Projeto não encontrado');

            return redirect()->route('projetos');
        }

        $Projeto->id_tecnico_apoio = $this->Tecnico;
        $Projeto->id_status = env('STATUS_ENVIADO_AUTORIZACAO', -1);
        $Projeto->save();

        Logs::log(
            $this->id,
            Session::get('s_userId'),
            env('STATUS_ENVIADO_AUTORIZACAO', -1)
        );

        //ENVIAR EMAIL AO INVESTIGADOR
        SendEmail::send(
            DB::table('users')->where('id', $Projeto->id_investigador)->first()->email,
            'Atribuição de Técnico de Apoio',
            'Foi atribuído um técnico de apoio ao seu projeto: ' . $Projeto->projeto . '.'
        );

        session()->flash('mensagem_sucesso', 'Técnico de apoio atribuído com sucesso!');

        return redirect()->route('projetos');
    }

    public function render()
    {
        $Projetos = DB::table('projeto')
            ->join('tipo_projeto', 'projeto.id_tipoprojeto', '=', 'tipo_projeto.id')
            ->join('financiamento', 'projeto.id_financiamento', '=', 'financiamento.id')
            ->join('status', 'projeto.id_status', '=', 'status.id')
            ->leftJoin('users as tecnico_apoio', 'projeto.id_tecnico_apoio', '=', 'tecnico_apoio.id')
            ->join('users as investigador', 'projeto.id_investigador', '=', 'investigador.id')
            ->select(
                'projeto.*',
                'tipo_projeto.tipoprojeto as tipo_projeto',
                'investigador.nome as nome_investigador',
                'tecnico_apoio.nome as nome_tecnico',
                'financiamento.financiamento as financiamento',
                'status.status as status',
                'status.id as id_status'
            );

        if (Session::get('s_idTipoUtilizador') == env('TIPO_INVESTIGADOR', -1)) {
            $Projetos = $Projetos->where('id_investigador', Session::get('s_userId'))
                ->get();
        }

        if (Session::get('s_idTipoUtilizador') == env('TIPO_TECNICO', -1)) {
            $Projetos = $Projetos->where('id_status', env('STATUS_ENVIADO', -1))
                ->get();
        }

        $TecnincoApoio = DB::table('users')
            ->where('id_tipo_utilizador', env('TIPO_TECNICO', -1))
            ->get();

        return view('livewire.projeto.ver-projeto', [
            'projetos' => $Projetos,
            'tecnicos' => $TecnincoApoio,
        ])->extends('layouts.master');
    }
}
