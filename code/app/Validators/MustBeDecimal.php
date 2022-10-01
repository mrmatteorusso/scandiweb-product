<?php
// include_once '../utils/helpers.php';


class MustBeADecimal
{



    public function __invoke($field, $data)
    {
        if (preg_match('/^[0-9]+(\.[0-9]{0,2})?$/', $data[$field])) {
            return $data[$field];
        }
        throw new Exception("$field must be a decimal number", 422);
    }
}
