<?php
 class Product extends Crud {
    private PDO $conn;
    private string $sku;
    private string $name;
    private string $price;
    private string $product_type;
    private string $product_attribute;
    private string  $_ids;
    public function __construct(Db $database,?array $data)
    {
        $this->conn = $database->getConnection();
        $this->name = $data['name'] ?? "";
        $this->sku = $data['sku'] ?? "";
        $this->price = $data['price'] ?? "";
        $this->product_type = $data['product_type'] ?? "";
        $this->product_attribute = $data['product_attribute']?? "";
        $this->_ids=$data["ids"] ?? "";
    }
    function create():void{
      
     
      
        $sql = "INSERT INTO product (sku, name, price,product_type,product_attribute)
        VALUES (:sku,:name, :price, :product_type,:product_attribute)";
        
$stmt = $this->conn->prepare($sql);
$stmt->bindValue(":sku",  $this->sku , PDO::PARAM_STR);
$stmt->bindValue(":name",  $this->name, PDO::PARAM_STR);
$stmt->bindValue(":price",  $this->price ?? 0, PDO::PARAM_INT);
$stmt->bindValue(":product_type",  $this->product_type, PDO::PARAM_STR);
$stmt->bindValue(":product_attribute",  $this->product_attribute, PDO::PARAM_STR);


$stmt->execute();


    }
 public function getAll():array{
        $sql = "SELECT *
        FROM product ORDER BY id DESC";
        
$stmt = $this->conn->query($sql);
$result =$stmt->fetchAll(PDO::FETCH_ASSOC);
return $result;


    }
    public function getOne():array{
        $sql = "SELECT *
        FROM product  WHERE sku =? ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([ $this->sku ]);
       


        $result =$stmt->fetchAll(PDO::FETCH_ASSOC);
       
        

return $result;


    }
  
   
    public  function deleteAll(){
       $ids = htmlspecialchars($this->_ids);
        $sql = "DELETE FROM product WHERE id IN $ids";
        $stmt = $this->conn->prepare($sql);
 
 

$stmt->execute();



    }
    public function getValidationErrors(): array
    {
        $errors = [];
       
        
        if (  !$this->name) {
            $errors[] = "name is required";
        }
        if ( !$this->sku) {
            $errors[] = "sku is required";
        }
        if ( !$this->price) {
            $errors[] = "price is required";
        }
        if ( !$this->product_type) {
            $errors[] = "product_type is required";
        }
        if ( !$this->product_attribute) {
            $errors[] = "product_attribute is required";
        }
        if ($this->price && filter_var($this->price, FILTER_VALIDATE_INT) === false) {
            
                $errors[] = "price must be an integer";
            
        }
        
       
        
        return $errors;
    }
}