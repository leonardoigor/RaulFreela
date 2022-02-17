<?php

namespace App\Http\repository;

use App\Http\Actions\BaseGovernoActionsBaseGovernoActions\BaseGovernoCheckExistAction;
use App\Http\Actions\BaseGovernoActionsBaseGovernoActions\BaseGovernoGetByCpfAction;
use App\Http\Actions\BaseGovernoActionsBaseGovernoActions\BaseGovernoSaveAction;

class BaseGovernoRepository
{
    public function save($data)
    {
        try {
            $exits = BaseGovernoCheckExistAction::checkIfExistByCpf($data);
            if ($exits) {
                $baseGoverno = BaseGovernoGetByCpfAction::getByCpfg($data);
                // $baseGoverno->delete();
                return $baseGoverno->update($data);;
            }
            return BaseGovernoSaveAction::save($data);
        } catch (\Exception $e) {
            return false;
        }
    }
}
