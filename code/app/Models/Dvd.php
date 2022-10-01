<?php

namespace App\Models;

use App\Validators\MustBeANumber;
use App\Validators\MustNotBeEmpty;

class Dvd extends Product
{
    public function setAttributes(array $data)
    {
        $this->attributes = json_encode(["size" => ["value" => $data['size'], "unit" => 'MB']]);
    }

    public function validationRules()
    {

        $commonRules = parent::validationRules();

        $dvdSpecificRules = [
            'size' => [
                new MustNotBeEmpty(),
                new MustBeANumber()
            ]
        ];
        return array_merge($commonRules, $dvdSpecificRules);
    }
}
