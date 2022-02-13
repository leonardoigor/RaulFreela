<?php

namespace App\Http\Actions\BaseExercitoActions;

use App\Models\BaseExercito;

class BaseExercitoSaveAction
{
    public static function save($data)
    {
        $data = BaseExercitoSaveAction::keys_array_lowercase($data);
        $model = new BaseExercito();
        $fillables = $model->getfillable();
        // dd($data, $fillables);
        $newdata = array();
        foreach ($fillables as $key => $value) {
            $value = strtolower($value);
            if (isset($data[$value])) {
                $newdata[$value] = $data[$value];
            }
        }
        $data = BaseExercitoSaveAction::handle_paramenter($newdata);
        $result = BaseExercito::create($data);
        return $result->save();
    }
    public static function handle_paramenter($data)
    {
        $d = $data;
        $model = new BaseExercito();
        $fillables = $model->getfillable();
        $data = array_intersect_key($data, array_flip($fillables));
        $last_id = BaseExercito::orderBy('id', 'desc')->first();
        $data['id'] = $last_id->id + 1;
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
            // dd($data['liquido']);
        }
        if (isset($d['prec_cp'])) {
            $data['prec'] = $d['prec_cp'];
        }
        return $data;
    }
    public static function keys_array_lowercase($array)
    {

        return array_combine(array_map('strtolower', array_keys($array)), $array);
    }
}
