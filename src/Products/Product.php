<?php

namespace Src\Products;

abstract class product
{
    private $id;
    private string $sku;
    private string $name;
    private string $product_type;
    private string $product_attribute;
    private int $price;


    public function __construct($sku, $name, $price, $product_type, $product_attribute)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->product_type = $product_type;
        $this->product_attribute = $product_attribute;
    }
    abstract public function getProperties(): array;
    public function setId(int $id): void
    {
        $this->id = $id;
    }


    public function getSku(): string
    {
        return $this->sku;
    }


    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function setName(string $name): void
    {
        $this->name = $name;
    }


    public function getPrice(): int
    {
        return $this->price;
    }


    public function setPrice(int $price): void
    {
        $this->price = $price;
    }
    public function getProduct_type(): string
    {
        return $this->product_type;
    }


    public function setProduct_type(string $product_type): void
    {
        $this->product_type = $product_type;
    }
    public function getProduct_attribute(): string
    {
        return $this->product_attribute;
    }


    public function setProduct_attribute(string $product_attribute): void
    {
        $this->product_attribute = $product_attribute;
    }
}
