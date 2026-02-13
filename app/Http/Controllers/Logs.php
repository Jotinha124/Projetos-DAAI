<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Support\Facades\Log as LaravelLog;
use App\Models\Projeto;
use App\Models\Status;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Logs extends Controller
{
    public static function log($id_projeto, $id_user, $id_status)
    {
        $Log = Log::create([
            'id_projeto' => $id_projeto,
            'id_user' => $id_user,
            'id_status' => $id_status,
            'data' => date('Y-m-d H:i:s')
        ]);

        if ($Log) {

            $User = User::find($id_user);

            if ($User) {

                $Projeto = Projeto::find($id_projeto);

                $Estado = Status::find($Projeto->id_status);
            }

            if ($id_status == env('STATUS_ENVIADO_AUTORIZACAO', -1)) {
                try {
                    SendEmail::send(
                        DB::table('users')->where('id', $Projeto->id_investigador)->first()->email,
                        'Atribuição de Técnico de Apoio',
                        'Foi atribuído um técnico de apoio ao seu projeto: ' . $Projeto->projeto . '.'
                    );
                    LaravelLog::info('Email enviado com sucesso');
                    return true;
                } catch (Exception $e) {
                    LaravelLog::error('Erro ao enviar email: ' . $e->getMessage());
                    return false;
                }
            } else {
                $body = "<div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6;'>
                            <h2 style='color: #0d6efd;'>Atualização do Projeto</h2>
                            <p>Olá <strong>{$User->nome}</strong>,</p>
                            <p>O projeto <strong>{$Projeto->projeto}</strong> foi atualizado com sucesso. Seguem os detalhes:</p>
                            <table style='width:100%; border-collapse: collapse; margin-top: 10px;'>
                                <tr>
                                    <td style='padding: 8px; border: 1px solid #ddd;'><strong>Nome:</strong></td>
                                    <td style='padding: 8px; border: 1px solid #ddd;'>{$Projeto->projeto}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 8px; border: 1px solid #ddd;'><strong>Descrição:</strong></td>
                                    <td style='padding: 8px; border: 1px solid #ddd;'>{$Projeto->sumario}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 8px; border: 1px solid #ddd;'><strong>Estado:</strong></td>
                                    <td style='padding: 8px; border: 1px solid #ddd;'>{$Estado->status}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 8px; border: 1px solid #ddd;'><strong>Atualização:</strong></td>
                                    <td style='padding: 8px; border: 1px solid #ddd;'>{$Projeto->updated_at->format('d/m/Y H:i')}</td>
                                </tr>
                            </table>
                            <p style='margin-top: 20px;'>Atenciosamente,<br><strong>Equipe do Sistema</strong></p>
                        </div>
                        ";
                try {
                    SendEmail::send($User->email, $Projeto->projeto, $body);
                    LaravelLog::info('Email enviado com sucesso');
                    return true;
                } catch (Exception $e) {
                    LaravelLog::error('Erro ao enviar email: ' . $e->getMessage());
                    return false;
                }
            }

            return true;
        } else {
            return false;
        }
    }
}
