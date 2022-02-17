<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseExercitoEmp extends Model
{
    protected $table = 'base_exercito_emp';
    public $timestamps = false;
    protected $fillable = [
        'codom',
        'rm',
        'sigla',
        'cidade_om',
        'uf_om',
        'catnr',
        'cat',
        'prec',
        'nrpg',
        'pg',
        'idt',
        'idt_margem',
        'cpf',
        'nome',
        'banco_recebimento',
        'agencia',
        'conta',
        'bruto',
        'desconto',
        'liquido',
        'endereco',
        'bairro',
        'cidade',
        'uf',
        'cep',
        'ind',
        'cod',
        'valor',
        'prazo',
        'banco',
        'margem',
        'nascimento',
        'tipo',
        'id',
        'data_uso',
        'flag',
        'id_usuario',
        'status',
        'idade',
        'status_aniversario',
        'parcelas_oagas',
        'restante',
        'tabela',
        'inclusao'
    ];
}
