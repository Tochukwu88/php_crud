<?php



class ProductController
{
    private Product $product;
    private string $method;
    public function __construct(Product $product, string $method)
    {
        $this->product = $product;
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
        $this->product->deleteAll();
        http_response_code(200);
        echo json_encode((object) array('message' => 'successful'));
    }
    private function processRequest()
    {
        switch($this->method) {
            case 'POST':

                $data = $this->product->getProperties();
                $errors=$this->getValidationErrors($data);
                if (! empty($errors)) {
                    http_response_code(400);
                    echo json_encode((object) array('message' => $errors));
                    return;
                }
                $isProductExist =count($this->product->getOne())>0;

                if ($isProductExist) {
                    http_response_code(409);
                    echo json_encode((object) array('message' => 'Product already exists'));
                    return;
                }


                $this->product->create();
                http_response_code(201);
                echo json_encode((object) array('message' => 'successful'));

                break;

            case 'GET':
                echo json_encode($this->product->getAll());
                break;
            case 'DELETE':

                $this->product->deleteAll();
                http_response_code(200);
                echo json_encode((object) array('message' => 'successful'));
                break;

            default:
                http_response_code(405);
                header("Allow: GET, POST,DELETE");
        }
    }
    public function getValidationErrors($data): array
    {
        $errors = [];


        if (!$data['name']) {
            $errors[] = "name is required";
        }
        if (!$data['sku']) {
            $errors[] = "sku is required";
        }
        if (!$data['price']) {
            $errors[] = "price is required";
        }
        if (!$data['product_type']) {
            $errors[] = "product_type is required";
        }
        if (!$data['product_attribute']) {
            $errors[] = "product_attribute is required";
        }
        if ($data['price'] && filter_var($data['price'], FILTER_VALIDATE_INT) === false) {
            $errors[] = "price must be an integer";
        }



        return $errors;
    }
}
