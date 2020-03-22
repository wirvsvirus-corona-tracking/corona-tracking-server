<?
class Contact
{
    // table columns
    public $id;
    public $last_contact;
    public $profile_id_a;
    public $profile_id_b;

    // database connection
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function create()
    {
      $query = "INSERT INTO contact (profile_id_a, profile_id_b)
                VALUES (" . $this->profile_id_a . ", " . $this->profile_id_b . ")";

      $statement = $this->connection->prepare($query);
      $statement->execute();

      return $statement;
    }

    public function readOne()
    {
        $query = "SELECT id, last_contact, profile_id_a, profile_id_b
                  FROM contact
                  WHERE id = " . $this->id;

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement;
    }

    public function readAll()
    {
        $query = "SELECT id, last_contact, profile_id_a, profile_id_b
                  FROM contact";

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement;
    }

    public function update()
    {
        $query = "UPDATE contact
                  SET last_contact = CURRENT_TIMESTAMP
                  WHERE id = " . $this->id;

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement;
    }

    public function find()
    {
        $query = "SELECT id, last_contact, profile_id_a, profile_id_b
                  FROM contact
                  WHERE profile_id_a = " . $this->profile_id_a . " AND profile_id_b = " . $this->profile_id_b . " OR profile_id_a = " . $this->profile_id_b . " AND profile_id_b = " . $this->profile_id_a;

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement;
    }
}
?>
