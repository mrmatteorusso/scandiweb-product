<?php

namespace App\Models;

use App\Models\Model;
use App\Validators\MustBeANumber;
use App\Validators\MustBeUnique;
use App\Validators\MustNotBeEmpty;

class Product extends Model
{

    protected $table = 'products';

    public function getTable()
    {
        return $this->table;
    }

    public function validationRules()
    {
        $rules = [
            'sku' => [
                new MustNotBeEmpty(),
                new MustBeANumber(),
                new MustBeUnique(),
            ],
            'price' => [
                new MustNotBeEmpty(),
                new MustBeANumber(),
            ],
            'name' => [
                new MustNotBeEmpty(),
            ],

        ];
        return $rules;
    }
}
