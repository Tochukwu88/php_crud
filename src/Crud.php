<?php
abstract class Crud {
   
    abstract protected function create(array $data);
    abstract protected  function getAll();
    
   
    abstract protected  function deleteAll($ids);
}