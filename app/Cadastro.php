<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    
    protected $table = "Cadastro";
    protected $primaryKey = 'idCadastro';
    public $timestamps = false;
    
}
