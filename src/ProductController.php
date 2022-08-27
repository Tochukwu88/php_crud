<?php
class ProductController {
    public function __construct(private Product $product,private string $method)
    {
    }
    public function handleRequest(){
        $this->processRequest();
    }
    private function processRequest(){
        switch($this->method){

            case 'POST':
                $data = (array) json_decode(file_get_contents("php://input"), true);
              
             echo json_encode(  $this->product->create($data));
                break;

            case 'GET':
                echo json_encode($this->product->getAll()); 
                break;
            case 'DELETE':
                $data =  json_decode(file_get_contents("php://input"), true);
                echo json_encode(  $this->product->deleteAll($data));
                break;

            default:
            http_response_code(405);
                   header("Allow: GET, POST,DELETE");
                    
        }

    }


}
