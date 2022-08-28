<?php
 class Product extends Crud {
    private PDO $conn;
    
    public function __construct(Db $database)
    {
        $this->conn = $database->getConnection();
    }
    function create(array $data):object{
        $errors = $this->getValidationErrors($data);
        if ( ! empty($errors)) {
            http_response_code(400);
             return (object) array('message' => $errors); 
        }
     
        $isProductExist = $this->getOne($data["sku"]);
        if(count($isProductExist)> 0){
            http_response_code(409);
            $message = (object) array('message' => 'Product already exists'); 
            return $message;
        }
       
        $sql = "INSERT INTO product (sku, name, price,product_type,product_attribute)
        VALUES (:sku,:name, :price, :product_type,:product_attribute)";
        
$stmt = $this->conn->prepare($sql);
$stmt->bindValue(":sku", $data["sku"], PDO::PARAM_STR);
$stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);
$stmt->bindValue(":price", $data["price"] ?? 0, PDO::PARAM_INT);
$stmt->bindValue(":product_type", $data["product_type"], PDO::PARAM_STR);
$stmt->bindValue(":product_attribute", $data["product_attribute"], PDO::PARAM_STR);


$stmt->execute();
http_response_code(201);
$message = (object) array('message' => 'successful'); 
return $message;

    }
 public function getAll():array{
        $sql = "SELECT *
        FROM product ORDER BY id DESC";
        
$stmt = $this->conn->query($sql);
$result =$stmt->fetchAll(PDO::FETCH_ASSOC);
return $result;


    }
    public function getOne(string $sku):array{
        $sql = "SELECT *
        FROM product  WHERE sku =? ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$sku]);


        $result =$stmt->fetchAll(PDO::FETCH_ASSOC);
        

return $result;


    }
  
   
    public  function deleteAll($data){
        $_ids=htmlspecialchars($data["ids"]);
        $sql = "DELETE FROM product WHERE id IN $_ids";
        $stmt = $this->conn->prepare($sql);
 


$stmt->execute();
http_response_code(200);
$message = (object) array('message' => 'successful'); 
return $message;

    }
    private function getValidationErrors(array $data): array
    {
        $errors = [];
       
        
        if ( empty($data["name"])) {
            $errors[] = "name is required";
        }
        if ( empty($data["sku"])) {
            $errors[] = "sku is required";
        }
        if ( empty($data["price"])) {
            $errors[] = "price is required";
        }
        if ( empty($data["product_type"])) {
            $errors[] = "product_type is required";
        }
        if ( empty($data["product_attribute"])) {
            $errors[] = "product_attribute is required";
        }
        if (array_key_exists("price", $data)) {
            if (filter_var($data["price"], FILTER_VALIDATE_INT) === false) {
                $errors[] = "price must be an integer";
            }
        }
        
       
        
        return $errors;
    }
}