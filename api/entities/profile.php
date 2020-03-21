<?
class Profile
{
    // table columns
    public $id;
    public $guid;
    public $passphrase;
    public $state_id;

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function create()
    {
      $query = "INSERT INTO profile (guid, passphrase) VALUES (" . $this->$guid . ", " . $this->$passphrase . ")";
      $statement = $this->connection->prepare($query);

      $statement->execute();

      return $statement;
    }

    public function read()
    {
        $query = "SELECT id, guid, passphrase, state_id FROM profile";
        $statement = $this->connection->prepare($query);

        $statement->execute();

        return $statement;
    }

    public function read_one()
    {
        if (!checkPassphrase())
        {
            return;
        }

        $query = "SELECT id, guid, passphrase, state_id FROM profile WHERE guid = " . $this->$guid;
        $statement = $this->connection->prepare($query);

        $statement->execute();

        return $statement;
    }

    public function update()
    {
        if (!checkPassphrase())
        {
            return;
        }

        $query = "UPDATE profile SET state_id = " . $this->$state_id . " WHERE guid = " . $this->$guid;
        $statement = $this->connection->prepare($query);

        $statement->execute();

        updateContacts();

        return $statement;
    }

    public function delete()
    {
        if (!checkPassphrase())
        {
            return;
        }

        $query = "DELETE FROM profile WHERE guid = " . $this->$guid;
        $statement = $this->connection->prepare($query);

        $statement->execute();

        return $statement;
    }

    private function checkPassphrase()
    {
        $query = "SELECT passphrase FROM profile WHERE guid = " . $this->$guid;
        $statement = $this->connection->prepare($query);

        $statement->execute();

        $count = $statement->rowCount();

        if ($count > 0)
        {
            while ($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);

                $item = array
                (
                      "id" => $id,
                      "guid" => $guid,
                      "passphrase" => $passphrase,
                      "state_id" => $state_id
                );

                if ($item["passphrase"] == $this->$passphrase)
                {
                    return true;
                }
            }
        }

        return false;
    }

    private function updateContacts()
    {
        // TODO: update contacts
    }
}
?>
