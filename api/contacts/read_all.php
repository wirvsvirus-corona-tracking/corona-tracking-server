<?php
header("Content-Type: application/json; charset=UTF-8"); // tells the client what the content type of the returned content actually is
header("Access-Control-Allow-Methods: GET"); // specifies the method or methods allowed when accessing the resource in response to a preflight request
header("Access-Control-Max-Age: 3600"); // indicates how long (in seconds) the results of a preflight request can be cached
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // indicates which HTTP headers can be used during the actual request

include_once "../configuration/database.php";
include_once "../entities/contact_controller.php";
include_once "../entities/contact.php";

$httpResponseCode = 200;

$output = array();
$output["count"] = 0;
$output["body"] = array();

try
{
    $database = new Database();
    $connection = $database->getConnection();

    $contactController = new ContactController($connection);
    $contacts = $contactController->readAll();

    foreach ($contacts as $contact)
    {
        ++$output["count"];

        $item = array
        (
            "id" => $contact->id,
            "last_contact" => $contact->lastContact,
            "profile_id_a" => $contact->profileIdA,
            "profile_id_b" => $contact->profileIdB
        );

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
