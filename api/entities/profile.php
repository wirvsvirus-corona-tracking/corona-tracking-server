<?
class Profile
{
    // table columns
    public $id;
    public $guid;
    public $state_id;

    // database connection
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function create()
    {
      $this->createGuid();

      $query = "INSERT INTO profile (guid)
                VALUES (" . $this->guid . ")";

      $statement = $this->connection->prepare($query);
      $statement->execute();

      return $statement;
    }

    public function readOne()
    {
        $query = "SELECT id, guid, state_id
                  FROM profile
                  WHERE id = " . $this->id;

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement;
    }

    public function readAll()
    {
        $query = "SELECT id, guid, state_id
                  FROM profile";

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement;
    }

    public function update()
    {
        $query = "UPDATE profile
                  SET state_id = " . $this->state_id . "
                  WHERE id = " . $this->id;

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement;
    }

    public function delete()
    {
        $query = "DELETE FROM profile
                  WHERE id = " . $this->id;

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement;
    }

    public function find()
    {
        $query = "SELECT id, guid, state_id
                  FROM profile
                  WHERE guid = " . $this->guid;

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement;
    }

    private function createGuid()
    {
        $uid = uniqid('', true);
        $random_data = rand(11111, 99999) . $_SERVER['REQUEST_TIME'] . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] . $_SERVER['REMOTE_PORT'];

        $hash = hash('ripemd128', $uid . md5($random_data));

        $this->guid = strtoupper(substr($hash, 0, 32));
    }
}
?>
