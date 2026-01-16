<?php

namespace App\Http\Livewire\Projeto;

use App\Http\Controllers\Logs;
use App\Models\Anexo;
use App\Models\Projeto;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CriarProjeto extends Component
{
    use WithFileUploads;

    public $nomeProjeto;
    public $sumario;
    public $orcamento;
    public $TipoProjeto;
    public $documento;
    public $entidadesexternas;
    public $Financiamento;
    public $anexo;


    public function rules()
    {
        return [
            ''
        ];
    }

    public function criarProjeto()
    {
        // $this->validate();

        try {
            $pasta = "projeto" . $this->nomeProjeto . time();

            if ($this->documento && $this->documento->isValid()) {

                $file = $pasta . '/documento';

                $url = Storage::disk('projetos')->put($file, $this->documento);
            } else {
                $url = null;
            }

            $Projeto = Projeto::create([
                'projeto' => $this->nomeProjeto,
                'sumario' => $this->sumario,
                'orcamento' => $this->orcamento,
                'id_tipoprojeto' => $this->TipoProjeto,
                'documento' => $url,
                'entidades_externas' => $this->entidadesexternas,
                'id_financiamento' => $this->Financiamento,
                'id_status' => env('STATUS_DRAFT', -1),
                'id_investigador' => 1,
                'id_tecnico_apoio' => Session::get('s_userId'),
                'data' => date('Y-m-d H:i:s')
            ]);

            if ($Projeto) {
                //SE TIVER UM INVESTIGADOR TENHO DE CRIAR UMA EQUIPA?


                //INSERIR OS ANEXOS ASSOCIADOS AO PROJETO SE TIVER ANEXOS
                if (!empty($this->anexo)) {
                    foreach ($this->anexo as $arquivo) {
                        $file = $pasta . '/anexos';

                        if ($arquivo->isValid()) {
                            $urlAnexo = Storage::disk('projetos')->put($file, $arquivo);

                            $Anexo = Anexo::create([
                                'nome_anexo' => $arquivo->getClientOriginalName(),
                                'anexo' => $urlAnexo,
                                'id_projeto' => $Projeto->id,
                                'id_user' => Session::get('s_userId'),
                                'data' => date('Y-m-d H:i:s')
                            ]);
                        }
                    }
                }

                //LOGS DO PROJETO
                Logs::log(
                    $Projeto->id,
                    Session::get('s_userId'),
                    env('STATUS_DRAFT', -1)
                );

                session()->flash('mensagem_sucesso', 'Projeto criado com sucesso');
                return redirect('projetos');
            }
        } catch (Exception $e) {
            session()->flash('mensagem_erro', 'Erro ao criar projeto'. $e->getMessage());
        }
    }

    public function render()
    {
        $TipoPorjeto = DB::table('tipo_projeto')->get();

        $Financiamento = DB::table('financiamento')->get();

        return view('livewire.projeto.criar-projeto', [
            'tipos_projeto' => $TipoPorjeto,
            'financiamento' => $Financiamento
        ])->extends('layouts.master');
    }
}
