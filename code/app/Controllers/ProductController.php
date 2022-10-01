<?php

namespace App\Controllers;

use App\Models\Book;
use App\Models\Dvd;
use App\Models\Furniture;
use App\Models\Product;
use App\Validators\MustBelongToAllowedTypes;
use App\Validators\MustNotBeEmpty;
use App\Validators\Validator;

class ProductController
{
    public function index()
    {

        $products = (new Product())->readAll();

        return json_encode(["data" => $products], JSON_PRETTY_PRINT);
    }

    public function store()
    {
        $data = readJSON();
        $productTypeRule = [
            'type' => [
                new MustNotBeEmpty(),
                new MustBelongToAllowedTypes()
            ]
        ];

        Validator::validate($data, $productTypeRule);

        $validators = [
            'BOOK' => new Book(),
            'FURNITURE' => new Furniture(),
            'DVD' => new Dvd(),
        ];

        $product = $validators[$data['type']];
        $rules = $product->validationRules();

        Validator::validate($data, $rules);

        $product->sku = $data['sku'];
        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->type = $data['type'];
        $product->setAttributes($data);
        $product = $product->create();
        return json_encode(["data" => $product->getColumns()], JSON_PRETTY_PRINT);
    }

    public function massDelete()
    {
        $data = readJSON();

        (new Product())->massDelete($data["ids"]);
        return json_encode(implode(",", $data["ids"]) . " deleted", JSON_PRETTY_PRINT);
    }
}
