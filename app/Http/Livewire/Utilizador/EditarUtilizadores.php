<?php

namespace App\Http\Livewire\Utilizador;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditarUtilizadores extends Component
{
    public $id;
    public $nome;
    public $email;
    public $admin;
    public $TipoUtilizador;

    public function rules()
    {
        return [
            'nome' => 'required|min:3|max:100',
            'email' => 'required|min:3|email|max:100',
            'TipoUtilizador' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome é obrigatório',
            'nome.min' => 'O nome deve ter no minimo :min',
            'nome.max' => 'O nome deve ter no máximo :max',
            'email.required' => 'O email é obrigatório',
            'email.min' => 'O email deve ter no minimo :min',
            'email.max' => 'O email deve ter no máximo :max',
            'emaail.email' => 'Deve ser um email válido',
            'TipoUtilizador' => 'O tipo de utilizador é obrigatorio'
        ];
    }

    public function mount($id)
    {
        $this->id = $id;

        $Utilizador = User::find($id);

        $this->nome = $Utilizador->nome;
        $this->email = $Utilizador->email;
        $this->admin = $Utilizador->admin;
        $this->TipoUtilizador = $Utilizador->id_tipo_utilizador;
    }

    public function editarUtilizador()
    {
        $this->validate();

        try {
            if($this->admin){
                $this->admin = true;
            }else{
                $this->admin = false;
            }

            $Utilizador = User::find($this->id);

            $Utilizador->nome = $this->nome;
            $Utilizador->email = $this->email;
            $Utilizador->admin = $this->admin;
            $Utilizador->id_tipo_utilizador = $this->TipoUtilizador;

            $Utilizador->save();

            session()->flash('mensagem','Utilizador editado com sucesso');

            return redirect('utilizadores');
        }
        catch (Exception $e) {
            session()->flash('mensagem_erro', 'Erro a editar utilizador');
        }
    }

    public function render()
    {
        $TipoUtilizador = DB::table('tipo_utilizador')->get();

        return view('livewire.utilizador.editar-utilizadores',[
            'tipos_utilizador' => $TipoUtilizador
        ])->extends('layouts.master');
    }
}
