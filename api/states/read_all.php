<?php
header("Content-Type: application/json; charset=UTF-8"); // tells the client what the content type of the returned content actually is
header("Access-Control-Allow-Methods: GET"); // specifies the method or methods allowed when accessing the resource in response to a preflight request
header("Access-Control-Max-Age: 3600"); // indicates how long (in seconds) the results of a preflight request can be cached
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // indicates which HTTP headers can be used during the actual request

include_once "../configuration/database.php";
include_once "../entities/state_controller.php";
include_once "../entities/state.php";

$httpResponseCode = 200;

$output = array();
$output["count"] = 0;
$output["body"] = array();

try
{
    $database = new Database();
    $connection = $database->getConnection();

    $stateController = new StateController($connection);
    $states = $stateController->readAll();

    foreach ($states as $state)
    {
        ++$output["count"];

        $item = array();
        $item["id"] = $state->id;
        $item["name"] = $state->name;

        array_push($output["body"], $item);
    }
}
catch (Exception $exception)
{
    $httpResponseCode = 500;
}

http_response_code($httpResponseCode);
echo json_encode($output);
?>
