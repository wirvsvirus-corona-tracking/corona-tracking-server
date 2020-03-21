<?php
class Database
{
    private $host = "localhost";
    private $port = 3306;
    private $database = "<name of database>";
    private $user = "<name of user>";
    private $password = "<password of user>";
    private $connection;

    public function __construct()
    {
        try
        {
            // PDO (PHP Data Objects): lightweight, consistent interface for accessing databases in PHP
            $this->connection = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->database, $this->user, $this->password);
            $this->connection->exec("set names utf8");

            echo "Connecting to the database succeeded.";
        }
        catch (PDOException $exception)
        {
            echo "Connecting to the database failed with the following error message: '" . $exception->getMessage() . "'.";
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
?>
