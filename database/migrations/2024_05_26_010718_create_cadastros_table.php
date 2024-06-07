<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadastrosTable extends Migration
{
    public function up()
    {
        Schema::create('cadastros', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data_nascimento');
            $table->string('cep');
            $table->string('endereco');
            $table->string('numero');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('uf');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cadastros');
    }
}
