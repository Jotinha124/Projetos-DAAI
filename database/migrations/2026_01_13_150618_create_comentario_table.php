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
        Schema::create('comentario', function (Blueprint $table) {
            $table->id();
            $table->string('comentario');
            $table->date('data');

            $table->unsignedBigInteger('id_user');

            $table->unsignedBigInteger('id_projeto');

            $table->foreign('id_user')
                ->references('id')
                ->on('users');

            $table->foreign('id_projeto')
                ->references('id')
                ->on('projeto');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentario');
    }
};
