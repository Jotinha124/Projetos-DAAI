<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projeto', function (Blueprint $table) {
            $table->id();
            $table->string('projeto');
            $table->boolean('verificado')->default(false);
            $table->text('sumario');
            $table->string('documento');
            $table->float('orcamento');
            $table->boolean('verificadopresidencia')->default(false);

            $table->unsignedBigInteger('id_investigador')->nullable();

            $table->unsignedBigInteger('id_financiamento');

            $table->unsignedBigInteger('id_tecnico_apoio');

            $table->unsignedBigInteger('id_status');

            $table->unsignedBigInteger('id_tipoprojeto');

            $table->boolean('entidadesexternas')->default(false);

            $table->date('data');
            $table->date('data_decisao')->nullable();
            $table->date('data_fecho')->nullable();


            $table->foreign('id_investigador')
                ->references('id')
                ->on('users');

            $table->foreign('id_financiamento')
                ->references('id')
                ->on('financiamento');


            $table->foreign('id_tecnico_apoio')
                ->references('id')
                ->on('users');

            $table->foreign('id_status')
                ->references('id')
                ->on('status');

            $table->foreign('id_tipoprojeto')
                ->references('id')
                ->on('tipo_projeto');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projeto');
    }
};
