<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../entities/profile.php';

$data = json_decode(file_get_contents("php://input"));

if (empty($data->passphrase))
{
    echo '{';
    echo '}';
}
else
{
    $database = new Database();
    $connection = $database->getConnection();
    $profile = new Profile($connection);

    $profile->$passphrase = $data->passphrase;

    // TODO: get GUID and send it back
    if ($profile->create())
    {
        echo '{';
            echo '"guid": "<GUID>"';
        echo '}';
    }
    else
    {
        echo '{';
        echo '}';
    }
}
?>
