<?php

namespace App\Validators;

use Exception;

class MustBeANumber
{

    public function __invoke($field, $data)
    {
        if (is_numeric($data[$field])) {
            return $data[$field];
        }
        throw new Exception("$field must be a number", 422);
    }
}

//  tidiness
//  reusability
//  concern
