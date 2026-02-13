<?php

namespace App\Http\Livewire\Projeto;

use App\Http\Controllers\Logs;
use App\Http\Controllers\SendEmail;
use App\Models\Anexo;
use App\Models\Equipa;
use App\Models\Projeto;
use App\Models\User;
use App\Services\Operations;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CriarProjeto extends Component
{
    use WithFileUploads;

    public $passo = 1;

    public $nomeProjeto;
    public $sumario;
    public $orcamento;
    public $TipoProjeto;
    public $documento;
    public $entidadesexternas;
    public $Financiamento;
    public $anexo;
    public $IdInvestigador;
    public $email;

    public $investigadores;

    public $emailInvestigador;
    public $nomeUtilizador;

    public $equipa = [];
    public $contadorEquipa = 1;

    public $pesquisou = false;

    public function mount()
    {
        $this->investigadores = null;
    }

    protected function rules()
    {
        if ($this->passo === 1) {
            return [
                'nomeProjeto'   => 'required|string|max:255',
                'sumario'       => 'nullable|string',
                'orcamento'     => 'required|numeric|min:1',
                'TipoProjeto'   => 'required',
                'Financiamento' => 'required',
            ];
        }

        if ($this->passo === 2) {
            return [
                'anexo.*' => 'file|max:10240',
            ];
        }

        return [];
    }

    public function messages()
    {
        return [
            'nomeProjeto.required' => 'O Nome do Projeto é obrigatório.',
            'nomeProjeto.max' => 'O Nome do Projeto deve ter no máximo :max caracteres.',
            'sumario.max' => 'O Sumário deve ter no máximo :max caracteres.',
            'orcamento.required' => 'O Orçamento é obrigatório.',
            'orcamento.min' => 'O Orçamento deve ser maior que :min.',
            'TipoProjeto.required' => 'O Tipo de Projeto é obrigatório.',
            'Financiamento.required' => 'O Financiamento é obrigatório.',
        ];
    }

    public function next()
    {
        $this->validate();
        $this->passo++;
    }

    public function previous()
    {
        $this->passo--;
    }

    public function searchEmail()
    {
        $this->reset(['nomeUtilizador']);
        $this->pesquisou = true;

        $this->investigadores = User::where('email', $this->email)->get();

        $this->emailInvestigador = $this->email;
    }

    public function criarProjeto()
    {
        $this->passo = 3;
        // $this->validate();

        try {
            $pasta = "projeto" . $this->nomeProjeto . time();

            $Projeto = Projeto::create([
                'projeto' => $this->nomeProjeto,
                'sumario' => $this->sumario,
                'orcamento' => $this->orcamento,
                'id_tipoprojeto' => $this->TipoProjeto,
                'entidades_externas' => $this->entidadesexternas,
                'id_financiamento' => $this->Financiamento,
                'id_status' => env('STATUS_DRAFT', -1),
                'id_investigador' => Session::get('s_userId'),
                'data' => date('Y-m-d H:i:s')
            ]);

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

            //EQUIPA DO PROJETO
            if ($this->equipa) {
                foreach ($this->equipa as $equipa) {
                    $password = $this->generatePassword(8);

                    $User = User::where('email', $equipa['email'])->first();


                    if (!$User) {

                        $User = User::create([
                            'nome' => $equipa['nome'],
                            'email' => $equipa['email'],
                            'id_tipo_utilizador' => env('TIPO_INVESTIGADOR', -1),
                            'data' => date('Y-m-d H:i:s'),
                            'admin' => 0,
                            'password' => Hash::make($password)
                        ]);

                        SendEmail::send($this->emailInvestigador, 'Envio de Login', 'Login');
                    }
                    
                    $Equipa = Equipa::create([
                        'id_projeto' => $Projeto->id,
                        'id_user' => $User->id,
                    ]);
                }
            }

            //LOGS DO PROJETO
            Logs::log(
                $Projeto->id,
                Session::get('s_userId'),
                env('STATUS_DRAFT', -1)
            );

            session()->flash('mensagem_sucesso', 'Projeto criado com sucesso');
            return redirect()->route('projetos.rever', ['id' => Crypt::encrypt($Projeto->id)]);
        } catch (Exception $e) {
            session()->flash('mensagem_erro', 'Erro ao criar projeto' . $e->getMessage());
        }
    }

    public function addEquipa($id)
    {
        $id = Operations::decryptId($id);

        if (!$id) {
            session()->flash('mensagem_erro', 'Projeto não encontrado');

            return redirect()->route('projetos');
        }

        $User = User::find($id);

        if (!$User) {
            session()->flash('mensagem_erro', 'Utilizador não encontrado');

            return redirect()->route('projetos');
        }

        $this->equipa[] = [
            'id'    => $this->contadorEquipa++,
            'nome'  => $User->nome,
            'email' => $User->email,
        ];

        session()->flash('mensagem_sucesso', 'Investigador adicionado com sucesso!');

        $this->pesquisou = false;
        $this->email = '';
        $this->nomeUtilizador = '';
        $this->emailInvestigador = '';
    }

    public function removerMembro($id)
    {
        $id = Operations::decryptId($id);

        if (!$id) {
            session()->flash('mensagem_erro', 'Projeto não encontrado');

            return redirect()->route('projetos');
        }

        foreach ($this->equipa as $equipa) {
            if ($equipa['id'] === $id) {
                unset($this->equipa->id);
            }
        }

        $this->equipa = array_values($this->equipa);
    }

    public function addInvestigador()
    {
        $this->validate([
            'nomeUtilizador' => 'required',
            'emailInvestigador' => 'required|email',
        ]);

        $this->equipa[] = [
            'id'    => $this->contadorEquipa++,
            'nome'  => $this->nomeUtilizador,
            'email' => $this->emailInvestigador,
        ];

        session()->flash('mensagem_sucesso', 'Investigador adicionado com sucesso!');

        $this->pesquisou = false;
        $this->email = '';
        $this->nomeUtilizador = '';
        $this->emailInvestigador = '';
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
        $TipoPorjeto = DB::table('tipo_projeto')->get();

        $Financiamento = DB::table('financiamento')->get();

        return view('livewire.projeto.criar-projeto', [
            'tipos_projeto' => $TipoPorjeto,
            'financiamento' => $Financiamento,
            'investigadores' => $this->investigadores,
        ])->extends('layouts.master');
    }
}
