<?php

namespace App\Validators;

use App\Models\Product;
use Exception;

class MustBeUnique
{


    public function __invoke($field, $data)
    {
        $sku = $data[$field];
        $product = new Product();
        $product = $product->readWhere('sku', $sku);
        if (empty($product->getColumns())) {
            return $sku;
        } else {
            throw new Exception("$field must be unique", 422);
        }
    }
}
