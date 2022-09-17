<?php

namespace Src\Interfaces;

interface ProductServiceInterface
{
    public function createProduct(array $data): array;
    public function getAllProducts(): array;
    public function getOneProduct($field, $key): array;
    public function getValidationErrors($data): array;

    public function deleteAllProducts($_ids): void;
}
