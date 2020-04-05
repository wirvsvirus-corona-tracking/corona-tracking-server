<?php
class StateController
{
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function read($id)
    {
        $profiles = array();

        $query = "SELECT id, name
                  FROM state
                  WHERE id = " . $id;

        $statement = executeQuery($query);
        $states = fetchStates($statement);

        return $states;
    }

    public function readAll()
    {
        $query = "SELECT id, name
                  FROM state";

        $statement = executeQuery($query);
        $states = fetchStates($statement);

        return $states;
    }

    public function find($name)
    {
        $query = "SELECT id, name
                  FROM state
                  WHERE name = '" . $name . "'";

        $statement = executeQuery($query);
        $states = fetchStates($statement);

        return $states;
    }

    private function executeQuery($query)
    {
        $statement = $this->connection->prepare($query);
        $statement->execute();

        //print_r($statement->errorInfo());

        return $statement;
    }

    private static function fetchStates($statement)
    {
        $states = array();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
            $states = new State();
            $states->id = $row["id"];
            $states->name = $row["name"];

            array_push($states, $state);
        }

        return $states;
    }

    // database connection
    private $connection;
}
?>
