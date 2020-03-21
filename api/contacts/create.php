<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../entities/contact.php';
include_once '../entities/profile.php';

$data = json_decode(file_get_contents("php://input"));

if (empty($data->profile_guid_a) || empty($data->profile_guid_b))
{
    echo '{';
    echo '    "status_code": -1';
    echo '}';
}
else
{
    $database = new Database();
    $connection = $database->getConnection();

    $contact = new Contact($connection);

    $profile_a = new Profile($connection);
    $profile_a->guid = $data->profile_guid_a;

    $statement = $profile_a->find();
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

            $contact->profile_id_a = $item["id"];
        }
    }

    $profile_b = new Profile($connection);
    $profile_b->guid = $data->profile_guid_b;

    $statement = $profile_b->find();
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

            $contact->profile_id_b = $item["id"];
        }
    }

    if ($contact->create())
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
