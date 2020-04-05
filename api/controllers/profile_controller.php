<?php
class ProfileController
{
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function create()
    {
        $guid = ProfileController::createGuid();

        $query = "INSERT INTO profile (guid)
                  VALUES ('" . $guid . "')";

        executeQuery($query);

        return $guid;
    }

    public function read($id)
    {
        $query = "SELECT id, guid, state_id
                  FROM profile
                  WHERE id = " . $id;

        $statement = executeQuery($query);
        $profiles = fetchProfiles($statement);

        return $profiles;
    }

    public function readAll()
    {
        $query = "SELECT id, guid, state_id
                  FROM profile";

        $statement = executeQuery($query);
        $profiles = fetchProfiles($statement);

        return $profiles;
    }

    public function update($id, $stateId)
    {
        $query = "UPDATE profile
                  SET state_id = " . $stateId . "
                  WHERE id = " . $id;

        executeQuery($query);
    }

    public function delete($id)
    {
        $query = "DELETE FROM profile
                  WHERE id = " . $id;

        executeQuery($query);
    }

    public function find($guid)
    {
        $query = "SELECT id, guid, state_id
                  FROM profile
                  WHERE guid = '" . $guid . "'";

        $statement = executeQuery($query);
        $profiles = fetchProfiles($statement);

        return $profiles;
    }

    private function executeQuery($query)
    {
        $statement = $this->connection->prepare($query);
        $statement->execute();

        //print_r($statement->errorInfo());

        return $statement;
    }

    private static function fetchProfiles($statement)
    {
        $profiles = array();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
            $profile = new Profile();
            $profile->id = $row["id"];
            $profile->guid = $row["guid"];
            $profile->stateId = $row["state_id"];

            array_push($profiles, $profile);
        }

        return $profiles;
    }

    private static function createGuid()
    {
        $randomData = $_SERVER["HTTP_USER_AGENT"] . $_SERVER["REQUEST_TIME"] . bin2hex(openssl_random_pseudo_bytes(16)); // 16 bytes
        $hash = md5($randomData);
        $guid = strtoupper(substr($hash, 0, 32));

        return $guid;
    }

    // database connection
    private $connection;
}
?>
