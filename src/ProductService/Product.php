<?php

namespace Src\ProductService;

use Src\Interfaces\ProductServiceInterface;
use Src\Interfaces\DatabaseInterface;

class Product implements ProductServiceInterface
{
    private $product;
    public function __construct(DatabaseInterface $product)
    {
        $this->product = $product;
    }
    public function createProduct(array $data): array
    {
        $errors=$this->getValidationErrors($data);

        if (! empty($errors)) {
            return  array('message' => $errors,'statusCode' => 400);
        }
        $isProductExist =count($this->getOneProduct('sku', $data['sku']))>0;

        if ($isProductExist) {
            return  array('message' =>  'Product already exists','statusCode' => 409);
        }


        $this->product->create($data);
        return  array('message' =>  'Successful','statusCode' => 201);
    }
    public function getAllProducts(): array
    {
        return $this->product->getAll();
    }
    public function getOneProduct($field, $key): array
    {
        return $this->product->getOne($field, $key);
    }

    public function deleteAllProducts($_ids): void
    {
        $this->product->deleteAll($_ids);
    }
    public function getValidationErrors($data): array
    {
        $errors = [];


        if (!$data['name']) {
            $errors[] = "name is required";
        }
        if (!$data['sku']) {
            $errors[] = "sku is required";
        }
        if (!$data['price']) {
            $errors[] = "price is required";
        }
        if (!$data['product_type']) {
            $errors[] = "product_type is required";
        }
        if (!$data['product_attribute']) {
            $errors[] = "product_attribute is required";
        }
        if ($data['price'] && filter_var($data['price'], FILTER_VALIDATE_INT) === false) {
            $errors[] = "price must be an integer";
        }



        return $errors;
    }
}
