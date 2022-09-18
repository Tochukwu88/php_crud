<?php

namespace Src\Query;

use PDO;
use Src\Config\Db;
use Src\Interfaces\DatabaseInterface;

class Query implements DatabaseInterface
{
    private PDO $conn;
    private string $table;

    public function __construct(Db $database, string $table)
    {
        $this->conn = $database->getConnection();
        $this->table = $table;
    }
    public function create($data): void
    {
        $sql =  "INSERT INTO $this->table ".$this->getKeys($data)." VALUES ".$this->convertToWildCard($data);

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($this->getArrayValues($data));
    }
 public function getAll(): array
 {
     $sql = "SELECT *
        FROM $this->table ORDER BY id DESC";

     $stmt = $this->conn->query($sql);
     $result =$stmt->fetchAll(PDO::FETCH_ASSOC);
     return $result;
 }
    public function getOne($field, $value): array
    {
        $sql = "SELECT *
        FROM $this->table  WHERE $field =? ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([ $value]);



        $result =$stmt->fetchAll(PDO::FETCH_ASSOC);



        return $result;
    }


    public function deleteAll($_ids): void
    {
        $ids = htmlspecialchars($_ids);
        $sql = "DELETE FROM $this->table WHERE id IN $ids";
        $stmt = $this->conn->prepare($sql);



        $stmt->execute();
    }
    private function convertToWildCard(array $param): string
    {
        return "(".str_repeat('?,', count($param) - 1)."?)";
    }

    private function getKeys(array $param): string
    {
        return "(".implode(',', array_keys($param)).")";
    }

    private function getArrayValues(array $param): array
    {
        return array_values($param);
    }
}
