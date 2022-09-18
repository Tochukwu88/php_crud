<?php

namespace Src\ProductService;

use Src\Interfaces\ProductServiceInterface;
use Src\Interfaces\DatabaseInterface;
use Src\Products\Furniture;
use Src\Products\Dvd;
use Src\Products\Book;
use Src\Products\NewProduct;

class ProductService implements ProductServiceInterface
{
    private $product;
    private $newProduct;
    public function __construct(DatabaseInterface $product)
    {
        $this->product = $product;
        $this->newProduct = new NewProduct(array(
            "Dvd" => DVD::class,
            "Furniture" => Furniture::class,
            "Book" => Book::class
        ));
    }
    public function createProduct(array $data): array
    {
        $new = $this->newProduct->newProduct($data);
        $properties =$new->getProperties();
        $errors=$this->getValidationErrors($properties);

        if (! empty($errors)) {
            return  array('message' => $errors,'statusCode' => 400);
        }
        $isProductExist =count($this->getOneProduct('sku', $properties['sku']))>0;

        if ($isProductExist) {
            return  array('message' =>  'Product already exists','statusCode' => 409);
        }


        $this->product->create($properties);
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
