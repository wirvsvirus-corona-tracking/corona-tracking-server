<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../entities/profile.php';

$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$connection = $database->getConnection();

$profile = new Profile($connection);

if ($profile->create())
{
    echo '{';
    echo '    "guid": "' . $profile->guid . '"';
    echo '}';
}
else
{
    echo '{';
    echo '    "guid": ""';
    echo '}';
}
?>