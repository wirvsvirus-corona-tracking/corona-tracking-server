<?php
include_once "database.php";

$output = array();
$output["message"] = "Cleaning up the tables failed.";

try
{
    $database = new Database();
    $connection = $database->getConnection();

    $script = file_get_contents("data/database_cleanup.sql");

    $statement = $connection->prepare($script);
    $statement->execute();

    //print_r($statement->errorInfo());

    $output["message"] = "Cleaning up the tables succeeded.";
}
catch(PDOException $exception)
{
    $output["message"] = "Cleaning up the tables failed with the following error message: '" . $$exception->getMessage() . "'.";
}

http_response_code(200);
echo json_encode($output);
?>
