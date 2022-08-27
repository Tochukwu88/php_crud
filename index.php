<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
    require __DIR__ . "/src/$class.php";
});
set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");
header("Content-type: application/json; charset=UTF-8");
 
$parts = explode('/',$_SERVER['REQUEST_URI'] );


if ($parts[2] != "products") {
    http_response_code(404);
   echo json_encode( (object) array('message' => 'Not Found'));    
    exit;
}
$db = new Db('localhost','productDB','root','');
$product = new Product($db);

$productController = new ProductController($product,$_SERVER["REQUEST_METHOD"]);
$productController->handleRequest();

