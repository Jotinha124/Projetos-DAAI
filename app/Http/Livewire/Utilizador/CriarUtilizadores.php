<?php

namespace App\Http\Livewire\Utilizador;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CriarUtilizadores extends Component
{
    public $TipoUtilizador;
    public $nome;
    public $email;
    public $admin;

    public function rules()
    {
        return [
            'nome' => 'required|min:3|max:100',
            'email' => 'required|min:3|email|max:100',
            'TipoUtilizador' => 'required'
        ];
    }

    //NÃO ESTA A MOSTRAR POR CAUSA DO ESTILO
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

    public function criarUtilizador()
    {
        $this->validate();

        try {
            if($this->admin){
                $this->admin = true;
            }else{
                $this->admin = false;
            }

            $password = $this->generatePassword();

            $Utilizador = User::insert([
                'nome' => $this->nome,
                'email' => $this->email,
                'password' => Hash::make($password),
                'admin' => $this->admin,
                'id_tipo_utilizador' => $this->TipoUtilizador
            ]);

            //ENVIAR EMAIL COM PASSWORD
            
            session()->flash('mensagem','Utilizador criado com sucesso');
        } catch (Exception $e) {
            session()->flash('mensagem_erro', 'Erro a inserir utilizador');
        }
    }

    public function generatePassword()
    {
        return 123456;
    }

    public function render()
    {
        $TipoUtilizador = DB::table('tipo_utilizador')->get();

        return view('livewire.utilizador.criar-utilizadores', [
            'tipos_utilizador' => $TipoUtilizador
        ])->extends('layouts.master');
    }
}
