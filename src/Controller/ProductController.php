<?php

namespace Src\Controller;

use Src\Interfaces\ProductServiceInterface;
use Src\Interfaces\DatabaseInterface;
use Src\DbLogic\SqlLogic;
use Src\ProductService\ProductService;
use Src\Config\Db;

class ProductController
{
    private array $data;
    private DatabaseInterface $sql;
    private ProductServiceInterface $productService;
    private string $method;
    public function __construct(Db $db, array $data, string $method)
    {
        $this->data = $data;
        $this->sql = new SqlLogic($db, "product");
        $this->productService= new ProductService($this->sql);
        $this->method = $method;
    }
    public function handleRequest()
    {
        $this->processRequest();
    }
    public function handleDeleteRequest()
    {
        $this->processDeleteRequest();
    }
    private function processDeleteRequest()
    {
        // this->data['ids'] == "(id1,id2,id3...)";
        $this->productService->deleteAllProducts($this->data['ids']);
        http_response_code(200);
        echo json_encode((object) array('message' => 'successful'));
    }
    private function processRequest()
    {
        switch($this->method) {
            case 'POST':

                $response =  $this->productService->createProduct($this->data);

                http_response_code($response['statusCode']);
                echo json_encode((object) array('message' => $response['message']));

                break;

            case 'GET':
                echo json_encode($this->productService->getAllProducts());
                break;
            case 'DELETE':
                // this->data['ids'] == "(id1,id2,id3...)";
                $this->productService->deleteAllProducts($this->data['ids']);
                http_response_code(200);
                echo json_encode((object) array('message' => 'successful'));
                break;

            default:
                http_response_code(405);
                header("Allow: GET, POST,DELETE");
        }
    }
}
