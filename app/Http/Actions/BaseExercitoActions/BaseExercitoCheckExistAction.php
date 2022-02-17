<?php

namespace App\Http\Actions\BaseExercitoActions;

use App\Models\BaseExercito;

class BaseExercitoCheckExistAction
{
    public static function checkIfExistByCpf($cpf)
    {

        $baseExercito = BaseExercito::where('cpf', $cpf)->first();
        if ($baseExercito) {
            return true;
        }
        return false;
    }
}
