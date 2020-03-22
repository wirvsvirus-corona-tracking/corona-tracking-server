<?
header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../entities/profile.php';

$database = new Database();
$connection = $database->getConnection();

$profile = new Profile($connection);

$output = array();
$output["guid"] = "";

if ($profile->create())
{
    $output["guid"] = $profile->guid;
}

http_response_code(200);
echo json_encode($output);
?>
