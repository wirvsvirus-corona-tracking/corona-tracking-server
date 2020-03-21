<?php
class Database
{
    public $connection;

    private $host = "localhost";
    private $database = "corona_tracker";
    private $username = "<your_database_username>";
    private $password = "<your_database_password>";

    public function getConnection()
    {
        $this->connection = null;

        try
        {
            // PDO (PHP Data Objects): lightweight, consistent interface for accessing databases in PHP
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);
            $this->connection->exec("set names utf8");
        }
        catch (PDOException $exception)
        {
            echo "ERROR: " . $exception->getMessage();
        }

        return $this->connection;
    }
}
?>
