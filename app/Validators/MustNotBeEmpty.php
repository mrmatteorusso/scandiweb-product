<?php

namespace App\Validators;

use Exception;

class MustNotBeEmpty
{



    public function __invoke($field, $data)
    {
        if (isset($data[$field]) && $data[$field] != "") //use also REQUEST 
        {
            return;
        }
        throw new Exception("$field must not be empty", 422);
    }
}
