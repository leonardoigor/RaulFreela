<?php

namespace App\Http\Actions\BaseExercitoActions;

use App\Models\BaseExercito;

class BaseExercitoGetByCpfAction
{
    public static function getByCpfg($data)
    {
        return BaseExercito::where('cpf', $data['CPF'])->first();
    }
}
