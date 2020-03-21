<?
class Contact
{
    // table columns
    public $id;
    public $timestamp;
    public $profile_id_a;
    public $profile_id_b;

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function create()
    {
      $query = "INSERT INTO contact (profile_id_a, profile_id_b) VALUES (" . $this->$profile_id_a . ", " . $this->$profile_id_b . ")";
      $statement = $this->connection->prepare($query);

      $statement->execute();

      return $statement;
    }

    public function read()
    {
        $query = "SELECT id, timestamp, profile_id_a, profile_id_b FROM contact";
        $statement = $this->connection->prepare($query);

        $statement->execute();

        return $statement;
    }

    public function read_one()
    {
        $query = "SELECT id, timestamp, profile_id_a, profile_id_b FROM contact WHERE id = " . $this->$id;
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
