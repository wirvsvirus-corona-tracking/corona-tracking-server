<?php
include_once "database.php";

$output = array();
$output["message"] = "Setting up the tables failed.";

try
{
    $database = new Database();
    $connection = $database->getConnection();

    $script = file_get_contents("data/database_setup.sql");

    $statement = $connection->prepare($script);
    $statement->execute();

    //print_r($statement->errorInfo());

    $output["message"] = "Setting up the tables succeeded.";
}
catch(PDOException $exception)
{
    $output["message"] = "Setting up the tables failed with the following error message: '" . $$exception->getMessage() . "'.";
}

http_response_code(200);
echo json_encode($output);
?>
