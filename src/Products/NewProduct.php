<?php

namespace Src\Products;

class NewProduct
{
    private array $ProductTypeArray;

    public function __construct(array $typeArray)
    {
        $this->ProductTypeArray = $typeArray;
    }

    public function newProduct($data)
    {
        if (array_key_exists("product_type", $data)) {
            return new $this->ProductTypeArray[$data["product_type"]]($data);
        }

        return false;
    }
}
