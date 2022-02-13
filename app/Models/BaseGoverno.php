<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseGoverno extends Model
{
    protected $table = 'base_governo';

    protected $fillable = [
        'id',
        'banco_origem',
        'bairro',
        'cargo',
        'cep',
        'cidade',
        'cpf',
        'data_nasc',
        'dt_inclusao',
        'endereco',
        'idade',
        'margem',
        'nom_conveniada',
        'nome',
        'numero',
        'uf',
        'complemento',
        'vlr_desc',
        'vlr_bruto',
        'senha_rhe',
        'matricula',
        'orgao',
        'flag',
        'id_usuario',
        'status',
        'dt_saldo',
        'numero_contrato',
        'vlr_liquido',
        'vlr_saldo',
        'vlr_saldo_atual',
        'qtd_parc',
        'qtd_parc_pag',
        'dt_contrato',
        'updated_at',
        'created_at',
        'deleted_at',
        'tipo_vinculo',
        'data_ingresso',
        'cod_cargo',
        'secretaria_provimento',
        'lotacao',
        'situacao',
        'tempo_ingresso',
        'matricula_nova',
        'matricula_ipe',
        'matricula_ipe_nova',
        'senha_cch',
        'senha_epe',
        'senha',
        'vinculos',
        'telefone_principal',
        'email_principal',
        'carteira_hp'
    ];
}
