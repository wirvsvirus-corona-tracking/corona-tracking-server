<?
class Database
{
    // your database configuration
    private $database = "<name of database>"; // please use the name of your database here
    private $user = "<name of user>"; // please use the name of your database user here
    private $password = "<password of user>"; // please use the password of your database user here

    private $host = "localhost";
    private $port = 3306;
    private $connection;

    public function __construct()
    {
        try
        {
            // PDO (PHP Data Objects) = lightweight, consistent interface for accessing databases in PHP
            $this->connection = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->database, $this->user, $this->password);
            $this->connection->exec("set names utf8");
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
