<?php

declare(strict_types=1);
require __DIR__ . "/vendor/autoload.php";


use Src\Controller\ProductController;
use Src\Config\Db;

// set_error_handler("Src\Utils\ErrorHandler::handleError");
// set_exception_handler("Src\Utils\ErrorHandler::handleException");
header("Content-type: application/json; charset=UTF-8");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Max-Age: 1728000');

    die();
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');



$parts = explode('/', $_SERVER['REQUEST_URI']);
//workaround for issue with delete request on 000webhost
$deleteUrl = $parts[3] ?? null;

if ($parts[2] != "products") {
    http_response_code(404);
    echo json_encode((object) array('message' => 'Not Found'));
    exit;
}
//hardcoded it for simplicity
$db = new Db('localhost', 'productDB', 'root', '');
$data = (array) json_decode(file_get_contents("php://input"), true);

$productController = new ProductController($db, $data, $_SERVER["REQUEST_METHOD"]);

//workaround for issue with delete request on 000webhost
if ($deleteUrl == 'delete') {
    $productController->handleDeleteRequest();
} else {
    $productController->handleRequest();
}
