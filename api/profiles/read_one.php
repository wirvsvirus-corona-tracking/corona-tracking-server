<?
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../entities/profile.php';

$data = json_decode(file_get_contents("php://input"));

if (empty($data->guid))
{
    http_response_code(200);

    echo json_encode
    (
        array("count" => 0, "body" => array());
    );
}
else
{
    $database = new Database();
    $connection = $database->getConnection();

    $profile = new Profile($connection);
    $profile->guid = $data->guid;

    $statement = $profile->find();
    $count = $statement->rowCount();

    if ($count > 0)
    {
        $profiles = array();
        $profiles["count"] = $count;
        $profiles["body"] = array();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $item = array
            (
                  "id" => $id,
                  "guid" => $guid,
                  "state_id" => $state_id
            );

            array_push($profiles["body"], $item);
        }

        http_response_code(200);

        echo json_encode($profiles);
    }
    else
    {
        http_response_code(200);

        echo json_encode
        (
            array("count" => 0, "body" => array());
        );
    }
}
?>
