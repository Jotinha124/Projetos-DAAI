<?php

namespace App\Http\Livewire\Projeto;

use App\Models\Comentario;
use App\Models\Projeto;
use App\Services\Operations;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ComentarProjeto extends Component
{
    public $id;
    public $nomeProjeto;
    public $sumario;
    public $orcamento;
    public $tipoProjeto;
    public $Financiamento;
    public $entidadesExternas;

    public $comentarios;

    public $comentario;

    public function mount($id)
    {
        $id = Operations::decryptId($id);

        if(!$id){
            session()->flash('mensagem_erro', 'Projeto não encontrado');

            return redirect()->route('projetos');
        }

        $this->id = $id;

        $Projeto = Projeto::find($id);

        if (!$Projeto) {
            session()->flash('mensagem_erro', 'Projeto não encontrado');

            return redirect()->route('projetos');
        }

        $Comentarios = Comentario::where('id_projeto', $this->id)
            ->join('users', 'comentario.id_user', '=', 'users.id')
            ->select('comentario.*', 'users.nome as nomeUtilizador')
            ->orderBy('comentario.data', 'asc')
            ->get();

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

        $this->comentarios = $Comentarios;
    }

    public function comentar()
    {
        $this->validate(
            [
                'comentario' => 'required',
            ],
            [
                'comentario.required' => 'O campo comentário é obrigatório.',
            ]
        );

        $Comentario = Comentario::create([
            'comentario' => $this->comentario,
            'id_projeto' => $this->id,
            'id_user' => Session::get('s_userId'),
            'data' => date('Y-m-d H:i:s')
        ]);

        session()->flash('mensagem_sucesso', 'Comentário adicionado com sucesso!');

        return redirect()->route('projetos.comentar', ['id' => Crypt::encrypt($this->id)]);
    }

    public function render()
    {
        return view('livewire.projeto.comentar-projeto')->extends('layouts.master');
    }
}
