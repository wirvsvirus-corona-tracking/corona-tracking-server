<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../entities/profile.php';

$data = json_decode(file_get_contents("php://input"));

if (empty($data->guid))
{
    echo '{';
    echo '    "status_code": -1';
    echo '}';
}
else
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
        echo '{';
        echo '    "status_code": 0';
        echo '}';
    }
    else
    {
        echo '{';
        echo '    "status_code": -1';
        echo '}';
    }
}
?>