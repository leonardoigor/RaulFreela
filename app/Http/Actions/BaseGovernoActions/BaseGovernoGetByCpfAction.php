<?php

namespace App\Http\Actions\BaseGovernoActionsBaseGovernoActions;

use App\Models\BaseGoverno;

class BaseGovernoGetByCpfAction
{
    public static function getByCpfg($data)
    {
        return BaseGoverno::where('cpf', $data['CPF'])->first();
    }
}
