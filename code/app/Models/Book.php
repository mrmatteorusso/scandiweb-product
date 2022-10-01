<?php

namespace App\Models;

use App\Validators\MustBeANumber;
use App\Validators\MustNotBeEmpty;

class Book extends Product
{
    public function setAttributes(array $data)
    {
        $this->attributes = json_encode(["weight" => ["value" => $data['weight'], "unit" => "KG"]]);
    }

    public function validationRules()
    {
        $commonRules = parent::validationRules(); 

        $bookSpecificRules = [
            'weight' => [
                new MustNotBeEmpty(),
                new MustBeANumber()
            ]
        ];
        return array_merge($commonRules, $bookSpecificRules);

    }
}
