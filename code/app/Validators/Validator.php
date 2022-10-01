<?php

namespace App\Validators;

class Validator
{

    public static function validate(array $data, array $validationRules)
    {

        foreach ($validationRules as $field => $rules) {
            foreach ($rules as $rule) {
                $rule($field, $data);
            }
        }
    }
}
