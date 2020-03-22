<?
class State
{
    // table columns
    public $id;
    public $name;

    // database connection
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function readOne()
    {
        $query = "SELECT id, name
                  FROM state
                  WHERE id = " . $this->id;

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement;
    }

    public function readAll()
    {
        $query = "SELECT id, name
                  FROM state";

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement;
    }

    public function find()
    {
        $query = "SELECT id, name
                  FROM state
                  WHERE name = " . $this->name;

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement;
    }
}
?>
