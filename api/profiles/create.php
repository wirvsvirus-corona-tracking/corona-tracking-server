<?php
header("Content-Type: application/json; charset=UTF-8"); // tells the client what the content type of the returned content actually is
header("Access-Control-Allow-Methods: POST"); // specifies the method or methods allowed when accessing the resource in response to a preflight request
header("Access-Control-Max-Age: 3600"); // indicates how long (in seconds) the results of a preflight request can be cached
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // indicates which HTTP headers can be used during the actual request

include_once "../config/database.php";
include_once "../controllers/profile_controller.php";
include_once "../entities/profile.php";

$output = array();
$output["guid"] = "";

try
{
    $database = new Database();
    $connection = $database->getConnection();

    $profileController = new ProfileController($connection);
    $guid = $profileController->create();

    $output["guid"] = $guid;
}
catch (Exception $exception)
{
}

http_response_code(200);
echo json_encode($output);
?>
