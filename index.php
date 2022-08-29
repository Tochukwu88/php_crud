<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
    require __DIR__ . "/src/$class.php";
});
set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");
header("Content-type: application/json; charset=UTF-8");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


 
$parts = explode('/',$_SERVER['REQUEST_URI'] );


if ($parts[2] != "products") {
    http_response_code(404);
   echo json_encode( (object) array('message' => 'Not Found'));    
    exit;
}
$db = new Db('localhost','productDB','root','');
$data = (array) json_decode(file_get_contents("php://input"), true);
$product = new Product($db,$data);

$productController = new ProductController($product,$_SERVER["REQUEST_METHOD"]);
$productController->handleRequest();

