<?php

namespace Src\Config;

use PDO;

class Db
{
    private string $host;
    private string $name;
    private string $user;
    private string $password;
    public function __construct(
        string $host,
        string $name,
        string $user,
        string $password
    ) {
        $this->host = "localhost";
        $this->name = 'productDB';
        $this->user = 'root';
        $this->password = '';
    }

    public function getConnection(): PDO
    {
        $dsn = "mysql:host={$this->host};dbname={$this->name};charset=utf8";

        return new PDO($dsn, $this->user, $this->password, [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false
        ]);
    }
}
