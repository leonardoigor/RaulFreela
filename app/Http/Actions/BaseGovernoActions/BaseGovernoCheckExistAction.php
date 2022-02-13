<?php

namespace App\Http\Actions\BaseGovernoActionsBaseGovernoActions;

use App\Models\BaseGoverno;

class BaseGovernoCheckExistAction
{
    public static function checkIfExistByCpf($data)
    {
        $baseGoverno = BaseGoverno::where('cpf', $data['CPF'])->first();
        if ($baseGoverno) {
            return true;
        }
        return false;
    }
}
