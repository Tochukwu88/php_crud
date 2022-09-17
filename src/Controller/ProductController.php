<?php

namespace Src\Controller;

use Src\Interfaces\ProductServiceInterface;

class ProductController
{
    private $product;
    private $data;
    private string $method;
    public function __construct(ProductServiceInterface $product, $data, string $method)
    {
        $this->product = $product;
        $this->data = $data;

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
        $this->product->deleteAllProducts($this->data['ids']);
        http_response_code(200);
        echo json_encode((object) array('message' => 'successful'));
    }
    private function processRequest()
    {
        switch($this->method) {
            case 'POST':

                $response =  $this->product->createProduct($this->data);

                http_response_code($response['statusCode']);
                echo json_encode((object) array('message' => $response['message']));

                break;

            case 'GET':
                echo json_encode($this->product->getAllProducts());
                break;
            case 'DELETE':
                // this->data['ids'] == "(id1,id2,id3...)";
                $this->product->deleteAllProducts($this->data['ids']);
                http_response_code(200);
                echo json_encode((object) array('message' => 'successful'));
                break;

            default:
                http_response_code(405);
                header("Allow: GET, POST,DELETE");
        }
    }
}
