<?php
include_once "database.php";

$httpResponseCode = 200;

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
catch (Exception $exception)
{
    $httpResponseCode = 500;

    $output["message"] = "Setting up the tables failed with the following error message: '" . $$exception->getMessage() . "'.";
}

http_response_code($httpResponseCode);
echo json_encode($output);
?>
