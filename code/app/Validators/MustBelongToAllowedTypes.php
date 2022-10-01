<?php

namespace App\Validators;

use Exception;

class MustBelongToAllowedTypes
{
    private $allowedTypes = ["BOOK", "DVD", "FURNITURE"];


    public function __invoke($field, $data)
    {
        foreach ($this->allowedTypes as $type) {
            if ($type === $data[$field]) {
                return;
            }
        }

        throw new Exception("$data[$field] is not a recognised type", 422);
    }
}
