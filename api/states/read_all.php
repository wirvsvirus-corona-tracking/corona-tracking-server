<?
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../entities/state.php';

$database = new Database();
$connection = $database->getConnection();

$state = new State($connection);
$statement = $state->readAll();
$count = $statement->rowCount();

if ($count > 0)
{
    $states = array();
    $states["count"] = $count;
    $states["body"] = array();

    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $item = array
        (
              "id" => $id,
              "name" => $name
        );

        array_push($states["body"], $item);
    }

    http_response_code(200);

    echo json_encode($states);
}
else
{
    http_response_code(200);

    echo json_encode
    (
        array("count" => 0, "body" => array());
    );
}
?>
