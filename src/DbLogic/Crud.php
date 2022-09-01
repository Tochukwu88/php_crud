<?php

namespace Src\DbLogic;

abstract class Crud
{
    abstract protected function create();
    abstract protected function getAll();


    abstract protected function deleteAll();
}