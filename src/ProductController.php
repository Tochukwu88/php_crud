<?php
class ProductController {
    private Product $product;
    private string $method;
    public function __construct( Product $product, string $method)
    {
        $this->product = $product;
        $this->method = $method;
    }
    public function handleRequest(){
        $this->processRequest();
    }
    public function handleDeleteRequest(){
        $this->processDeleteRequest();
    }
    private function processDeleteRequest(){
        $this->product->deleteAll();
        http_response_code(200);
        echo json_encode( (object) array('message' => 'successful') );
    }
    private function processRequest(){
        switch($this->method){

            case 'POST':
               
                $errors = $this->product->getValidationErrors();
        if ( ! empty($errors)) {
            http_response_code(400);
            echo json_encode( (object) array('message' => $errors)); 
            return;
        }
        $isProductExist =count( $this->product->getOne())>0;
     
        if($isProductExist){
           
            http_response_code(409);
            echo json_encode(  (object) array('message' => 'Product already exists')); 
            return;
            
        }
       
              
              $this->product->create();
             http_response_code(201);
 echo json_encode( (object) array('message' => 'successful')); 

                break;

            case 'GET':
                echo json_encode($this->product->getAll()); 
                break;
            case 'DELETE':
               
                $this->product->deleteAll();
                http_response_code(200);
                echo json_encode( (object) array('message' => 'successful') );
                break;

            default:
            http_response_code(405);
                   header("Allow: GET, POST,DELETE");
                    
        }

    }
   

}
