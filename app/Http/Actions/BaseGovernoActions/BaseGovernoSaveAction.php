<?php

namespace App\Http\Actions\BaseGovernoActionsBaseGovernoActions;

use App\Models\BaseGoverno;

class BaseGovernoSaveAction
{
    public static function save($data)
    {
        $data = array_combine(array_map('strtolower', array_keys($data)), $data);
        $model = new BaseGoverno();
        $fillables = $model->getfillable();
        // dd($data, $fillables);
        $newdata = array();
        foreach ($fillables as $key => $value) {
            $value = strtolower($value);
            if (isset($data[$value])) {
                $newdata[$value] = $data[$value];
            }
        }
        $data = array_intersect_key($data, array_flip($fillables));
        $last_id = BaseGoverno::orderBy('id', 'desc')->first();
        $data['id'] = $last_id->id + 1;
        // dd($data);
        $result = BaseGoverno::create($data);

        return $result;
    }
}
