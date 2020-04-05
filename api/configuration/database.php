<?php
include_once "data/database_credentials.php";

class Database
{
    public function __construct()
    {
        $host = DB_CONFIG["host"];
        $port = DB_CONFIG["port"];
        $name = DB_CONFIG["name"];
        $user = DB_CONFIG["user"];
        $password = DB_CONFIG["password"];

        // PDO (PHP Data Objects) = lightweight, consistent interface for accessing databases in PHP
        $this->connection = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $name, $user, $password);

        // set the character set to UTF-8
        $statement = $this->connection->prepare("set names utf8");
        $statement->execute();

        //print_r($statement->errorInfo());
    }

    public function getConnection()
    {
        return $this->connection;
    }

    private $connection;
}
?>
