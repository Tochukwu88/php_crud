<?php

namespace Src\Interfaces;

interface DatabaseInterface
{
    public function create($data): void;
    public function getAll(): array;
    public function getOne($field, $value): array;

    public function deleteAll($_ids): void;
}
