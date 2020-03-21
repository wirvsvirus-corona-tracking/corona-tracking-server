<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../entities/contact.php';

$data = json_decode(file_get_contents("php://input"));

if (empty($data->profile_id_a) || empty($data->profile_id_b))
{
    echo '{';
      echo '"status_code": -1';
    echo '}';
}
else
{
    $database = new Database();
    $connection = $database->getConnection();
    $contact = new Contact($connection);

    $contact->$profile_id_a = $data->profile_id_a;
    $contact->$profile_id_b = $data->profile_id_b;

    // TODO: get GUID and send it back
    if ($contact->create())
    {
        echo '{';
            echo '"status_code": 0';
        echo '}';
    }
    else
    {
        echo '{';
            echo '"status_code": -1';
        echo '}';
    }
}
?>
