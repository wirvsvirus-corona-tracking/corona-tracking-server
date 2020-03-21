<?
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../entities/profile.php';

$database = new Database();
$connection = $database->getConnection();
$profile = new Profile($connection);

$statement = $profile->read();
$count = $statement->rowCount();

if ($count > 0)
{
    $profiles = array();
    $profiles["body"] = array();
    $profiles["count"] = $count;

    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $item = array
        (
              "id" => $id,
              "guid" => $guid,
              "passphrase" => $passphrase,
              "state_id" => $state_id
        );

        http_response_code(200);

        array_push($profiles["body"], $item);
    }

    echo json_encode($profiles);
}
else
{
    http_response_code(200);

    echo json_encode
    (
        array("body" => array(), "count" => 0);
    );
}
?>
