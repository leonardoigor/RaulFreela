<?php

namespace App\Http\Actions\BaseExercitoActions;

use App\Models\BaseExercito;

class BaseExercitoCheckExistAction
{
    public static function checkIfExistByCpf($data)
    {
        $baseExercito = BaseExercito::where('cpf', $data['CPF'])->first();
        if ($baseExercito) {
            return true;
        }
        return false;
    }
}
