<?php

namespace App\Http\repository;

use App\Http\Actions\BaseExercitoActions\BaseExercitoCheckExistAction;
use App\Http\Actions\BaseExercitoActions\BaseExercitoGetByCpfAction;
use App\Http\Actions\BaseExercitoActions\BaseExercitoSaveAction;
use App\Logger;

class BaseExercitoRepository
{
    public Logger $logger;
    public function __construct()
    {
        $this->logger = new Logger('BaseExercitoRepository_errros', 'UploadController');
    }
    public function save($data)
    {
        try {
            $logger = new Logger('BaseExercitoRepository_success', 'UploadController');
            // $cpf = $data['CPF'];
            // $exits = BaseExercitoCheckExistAction::checkIfExistByCpf($cpf);
            // if ($exits) {
            //     $BaseExercito = BaseExercitoGetByCpfAction::getByCpfg($cpf);
            //     // $result = $BaseExercito->update($data);
            //     $BaseExercito->delete();
            //     $logger->log_msg('BaseExercito atualizado ' . json_encode($BaseExercito));
            //     // return $result;
            // }
            // dd
            $result = BaseExercitoSaveAction::save($data);
            $logger->log_msg('BaseExercito salvo ' . json_encode($data));
            return $result;
        } catch (\Exception $e) {
            $this->logger->log_msg("Error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteFile($file)
    {
        try {
            return unlink($file);
        } catch (\Exception $e) {
            $this->logger->log_msg("Error: " . $e->getMessage());
            return false;
        }
    }
}
