<?
class State
{
    // table columns
    public $id;
    public $name;

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function create()
    {
        // do nothing
    }

    public function read()
    {
        $query = "SELECT id, name FROM state";
        $statement = $this->connection->prepare($query);

        $statement->execute();

        return $statement;
    }

    public function read_one()
    {
        $query = "SELECT id, name FROM state WHERE id = " . $this->$id;
        $statement = $this->connection->prepare($query);

        $statement->execute();

        return $statement;
    }

    public function update()
    {
        // do nothing
    }

    public function delete()
    {
        // do nothing
    }
}
?>
