<?php

namespace App\Http\repository;

use App\Http\Actions\BaseExercitoActions\BaseExercitoCheckExistAction;
use App\Http\Actions\BaseExercitoActions\BaseExercitoGetByCpfAction;
use App\Http\Actions\BaseExercitoActions\BaseExercitoSaveAction;

class BaseExercitoRepository
{
    public function save($data)
    {
        // dd($data);
        try {
            $exits = BaseExercitoCheckExistAction::checkIfExistByCpf($data);
            if ($exits) {
                $BaseExercito = BaseExercitoGetByCpfAction::getByCpfg($data);
                return $BaseExercito->update($data);;
            }
            return BaseExercitoSaveAction::save($data);
        } catch (\Exception $e) {
            dd('Error: ', $e->getMessage());
            return false;
        }
    }

    public function deleteFile($file)
    {
        try {
            return unlink($file);
        } catch (\Exception $e) {
            dd('Error: ', $e->getMessage());
            return false;
        }
    }
}
