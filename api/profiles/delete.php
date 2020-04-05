<?php
header("Content-Type: application/json; charset=UTF-8"); // tells the client what the content type of the returned content actually is
header("Access-Control-Allow-Methods: DELETE"); // specifies the method or methods allowed when accessing the resource in response to a preflight request
header("Access-Control-Max-Age: 3600"); // indicates how long (in seconds) the results of a preflight request can be cached
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // indicates which HTTP headers can be used during the actual request

include_once "../config/database.php";
include_once "../entities/profile_controller.php";
include_once "../entities/profile.php";

$httpResponseCode = 200;

$output = array();
$output["status_code"] = -1; // -1 = error

try
{
    $guid = $_GET["guid"];

    if (isset($guid) && !empty($guid))
    {
        $database = new Database();
        $connection = $database->getConnection();

        $profileController = new ProfileController($connection);
        $profiles = $profileController->find($guid);

        foreach ($profiles as $profile)
        {
            $profileController->delete($profile->id);
        }

        $output["status_code"] = 0; // 0 = no error
    }
}
catch (Exception $exception)
{
    $httpResponseCode = 500;
}

http_response_code($httpResponseCode);
echo json_encode($output);
?>
