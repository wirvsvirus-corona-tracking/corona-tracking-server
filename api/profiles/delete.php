<?
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../entities/profile.php';

$data = json_decode(file_get_contents("php://input"));

$output = array();
$output["status_code"] = -1; // -1 = error

if (!empty($data->guid))
{
    $database = new Database();
    $connection = $database->getConnection();

    $profile = new Profile($connection);
    $profile->$guid = $data->guid;

    $statement = $profile->find();
    $count = $statement->rowCount();

    if ($count > 0)
    {
        while ($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $item = array
            (
                "id" => $id,
                "guid" => $guid,
                "state_id" => $state_id
            );

            $profile->id = $item["id"];
        }
    }

    if ($profile->delete())
    {
        $output["status_code"] = 0; // 0 = no error
    }
}

http_response_code(200);
echo json_encode($output);
?>
