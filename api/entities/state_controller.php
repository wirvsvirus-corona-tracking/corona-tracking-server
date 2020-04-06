<?php
include_once "state.php";

class StateController
{
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function read($id)
    {
        $query = "SELECT id, name
                  FROM state
                  WHERE id = " . $id;

        $statement = $this->executeQuery($query);
        $states = StateController::fetchStates($statement);

        return $states;
    }

    public function readAll()
    {
        $query = "SELECT id, name
                  FROM state";

        $statement = $this->executeQuery($query);
        $states = StateController::fetchStates($statement);

        return $states;
    }

    public function find($name)
    {
        $query = "SELECT id, name
                  FROM state
                  WHERE name = '" . $name . "'";

        $statement = $this->executeQuery($query);
        $states = StateController::fetchStates($statement);

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
            $state = new State();
            $state->id = $row["id"];
            $state->name = $row["name"];

            array_push($states, $state);
        }

        return $states;
    }

    // database connection
    private $connection;
}
?>
