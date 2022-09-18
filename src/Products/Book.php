<?php

namespace Src\Products;

class Book extends Product
{
    public function __construct(array $params)
    {
        parent::__construct($params["sku"], $params["name"], $params["price"], $params["product_type"], $params["product_attribute"]);
    }
    public function getProperties(): array
    {
        return array(

            "sku" => $this->getSku(),
            "name" => $this->getName(),
            "price" => $this->getPrice(),
            "product_type" => "Book",
            "product_attribute" =>  $this->getProduct_attribute(),

        );
    }
}
