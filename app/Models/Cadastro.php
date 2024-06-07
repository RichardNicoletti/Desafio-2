<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    protected $fillable = [
        'nome', 
        'data_nascimento', 
        'cep', 
        'endereco', 
        'numero', 
        'bairro', 
        'cidade', 
        'uf'
    ];
}
