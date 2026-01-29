<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // STATUS DISPONIVEIS
        DB::table('status')->insert([
            ['id' => 1, 'status' => 'Draft'],
            ['id' => 2, 'status' => 'Enviado'],
            ['id' => 3, 'status' => 'Enviado para autorização'],
            ['id' => 4, 'status' => 'Autorizado'],
            ['id' => 5, 'status' => 'Iniciado'],
            ['id' => 6, 'status' => 'Terminado'],
            ['id' => 7, 'status' => 'Reprovado'],
            ['id' => 8, 'status' => 'Cancelado'],
        ]);

        //TIPO PROJETO
        DB::table('tipo_projeto')->insert([
            ['id' => 1, 'tipoprojeto' => 'Interno'],
            ['id' => 2, 'tipoprojeto' => 'Externo'],
        ]);

        //FINANCIAMENTO
        DB::table('financiamento')->insert([
            ['id' => 1, 'financiamento' => 'Nacional', 'internacional' => false],
            ['id' => 2, 'financiamento' => 'Europeu', 'internacional' => true],
        ]);

        //TIPO UTILIZADOR
        DB::table('tipo_utilizador')->insert([
            ['id' => 1, 'tipo_utilizador' => 'Investigador'],
            ['id' => 2, 'tipo_utilizador' => 'Técnico Apoio'],
        ]);

        //USER
        DB::table('users')->insert([
            ['id' => 1, 'nome' => 'João Matias', 'email' => 'matiasjoaopedro19@gmail.com', 'password' => Hash::make('123456'), 'id_tipo_utilizador' => 1, 'admin' => false],
            ['id' => 2, 'nome' => 'Tecnico', 'email' => 'joaomatiasdev@gmail.com', 'password' => Hash::make('123456'), 'id_tipo_utilizador' => 2, 'admin' => true],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
