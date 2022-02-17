<?php

namespace App\Http\Actions\BaseExercitoActions;

use App\Logger;
use App\Models\BaseExercito;
use App\Models\BaseExercitoEmp;

class BaseExercitoSaveAction
{

    public static function save($data)
    {
        $data = BaseExercitoSaveAction::keys_array_lowercase($data);
        $model = new BaseExercito();
        $fillables = $model->getfillable();
        $newdata = array();
        $bank_emp_list = array();
        foreach ($fillables as $key => $value) {
            $value = strtolower($value);
            if (isset($data[$value])) {
                $newdata[$value] = $data[$value];
            }
        }
        if (!isset($data['margem_livre'])) {
            foreach ($data as $key => $value) {
                if (str_contains($key, '_emp')) {
                    $splitter = explode('_', $key);
                    if ($value != '' && $value > 0) {

                        $bankname = count($splitter) > 3 ? $splitter[2] . $splitter[3] : $splitter[2];
                        $bankname = str_replace('-', ' ', $bankname);
                        BaseExercitoSaveAction::handle_emp($splitter[0], $value, $newdata, $bankname);
                    }
                }
            }
        }
        $data = BaseExercitoSaveAction::handle_paramenter($newdata, $data);
        $result = BaseExercito::create($data);

        return $result->save();
    }
    public static function handle_emp($cod, $value, $data, $bank_name)
    {
        $logger = new Logger('BaseExercitoEmpRepository_success', 'UploadController');

        try {
            $data['cod'] = $cod;
            $data['valor'] = $value;
            $data['banco'] = $bank_name;
            $logger->log_msg('BaseExercitoEmp salvo ' . json_encode($value));

            return  BaseExercitoEmp::create($data);
        } catch (\Throwable $th) {
            $logger = new Logger('BaseExercitoEmpRepository_success', 'UploadController');
        }
    }
    public static function handle_paramenter($data, $dataUnmutted)
    {
        $d = $data;
        $model = new BaseExercito();
        $fillables = $model->getfillable();
        $data = array_intersect_key($data, array_flip($fillables));
        $last_id = BaseExercito::orderBy('id', 'desc')->first();
        if (!$last_id) {
            $data['id'] = 1;
        } else {
            $data['id'] = $last_id->id + 1;
        }
        if (isset($d['rm'])) {
            $data['rm'] = intval($d['rm']);
            $data['rm'] = strval($d['rm']);
        }
        if (isset($d['nrpg'])) {
            $data['nrpg'] = intval($d['nrpg']);
            $data['nrpg'] = strval($d['nrpg']);
        }
        if (isset($d['bruto'])) {
            $data['bruto'] = str_replace('.', '', $d['bruto']);
            $data['bruto'] = str_replace(',', '.', $data['bruto']);
            $data['bruto'] = floatval($data['bruto']);
        }
        if (isset($d['desconto'])) {
            $data['desconto'] = str_replace('.', '', $d['desconto']);
            $data['desconto'] = str_replace(',', '.', $data['desconto']);
            $data['desconto'] = floatval($data['desconto']);
        }
        if (isset($d['liquido'])) {
            $data['liquido'] = str_replace('.', '', $d['liquido']);
            $data['liquido'] = str_replace(',', '.', $data['liquido']);
            $data['liquido'] = floatval($data['liquido']);
        }
        if (isset($dataUnmutted['prec_cp'])) {
            $data['prec'] = $dataUnmutted['prec_cp'];
        }
        if (isset($dataUnmutted['margem_livre'])) {
            $data['margem'] = $dataUnmutted['margem_livre'];

            $data['margem'] = str_replace('.', '', $data['margem']);
            $data['margem'] = str_replace(',', '.', $data['margem']);
            $data['margem'] = floatval($data['margem']);
        }
        return $data;
    }
    public static function keys_array_lowercase($array)
    {

        return array_combine(array_map('strtolower', array_keys($array)), $array);
    }
}
