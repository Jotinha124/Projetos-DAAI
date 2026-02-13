<?php

namespace App\Http\Livewire\Utilizador;

use App\Http\Controllers\SendEmail;
use App\Models\User;
use App\Services\Operations;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Component;

class VerUtilizadores extends Component
{
    public function apagarUtilizador($id)
    {
        $id = Operations::decryptId($id);

        if (!$id) {
            session()->flash('mensagem_erro', 'Utilizador não encontrado');

            return redirect()->route('utilizadores');
        }

        $Utilizador = User::find($id);

        if (!$Utilizador) {

            session()->flash('mensagem_erro', 'Utilizador não encontrado');

            return redirect()->route('utilizadores');
        }

        User::find($id)->delete();
        session()->flash('mensagem', 'Utilizador apagado com sucesso');
    }

    public function resetarPassword($id)
    {
        $id = Operations::decryptId($id);

        if (!$id) {
            session()->flash('mensagem_erro', 'Utilizador não encontrado');

            return redirect()->route('utilizadores');
        }

        $Utilizador = User::find($id);

        if (!$Utilizador) {

            session()->flash('mensagem_erro', 'Utilizador não encontrado');

            return redirect()->route('utilizadores');
        }
        
        $password = $this->generatePassword();

        $Utilizador->update([
            'password' => Hash::make($password)
        ]);

        $body = view('emails.send-password', [
            'password' => $password
        ])->render();

        try{
            SendEmail::send($Utilizador->email, 'Resetar Password',$body);

            session()->flash('mensagem', 'Email enviado com sucesso');
            return redirect()->route('utilizadores');
        }catch (Exception $e){
            session()->flash('mensagem_erro', 'Erro a enviar email');
            return redirect()->route('utilizadores');
        }
    }

    function generatePassword($tamanho = 12)
    {
        $maiusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $minusculas = 'abcdefghijklmnopqrstuvwxyz';
        $numeros    = '0123456789';
        $simbolos   = '!@#$%^&*()-_=+';

        $todos = $maiusculas . $minusculas . $numeros . $simbolos;

        $password = '';
        $password .= $maiusculas[random_int(0, strlen($maiusculas) - 1)];
        $password .= $minusculas[random_int(0, strlen($minusculas) - 1)];
        $password .= $numeros[random_int(0, strlen($numeros) - 1)];
        $password .= $simbolos[random_int(0, strlen($simbolos) - 1)];

        for ($i = 4; $i < $tamanho; $i++) {
            $password .= $todos[random_int(0, strlen($todos) - 1)];
        }

        return str_shuffle($password);
    }

    public function render()
    {
        $Utilizadores = DB::table('users')
            ->join('tipo_utilizador', 'users.id_tipo_utilizador', '=', 'tipo_utilizador.id')
            ->join('status_utilizador', 'users.id_status_utilizador', '=', 'status_utilizador.id')
            ->select('users.*', 'tipo_utilizador.tipo_utilizador as tipo_utilizador', 'status_utilizador.status as status_utilizador')
            ->get();

        return view('livewire.utilizador.ver-utilizadores', [
            'Utilizadores' => $Utilizadores
        ])->extends('layouts.master');
    }
}
