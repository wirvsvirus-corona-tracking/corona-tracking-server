<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../entities/profile.php';
include_once '../entities/contact.php';

$data = json_decode(file_get_contents("php://input"));

$output = array();
$output["status_code"] = -1; // -1 = error

if (!empty($data->guid) &&
    !empty($data->state_id))
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

    $profile->$state_id = $data->state_id;

    if ($profile->update())
    {
        $output["status_code"] = 0; // 0 = no error

        if ($profile->$state_id == 1) // 1 = infected
        {
            // the current profile was infected therefore update all profiles that had contact with the current profile

            $contact = new Contact($connection);

            $statement = $contact->readAll();
            $count = $statement->rowCount();

            if ($count > 0)
            {
                while ($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    extract($row);

                    $item = array
                    (
                        "id" => $id,
                        "last_contact" => $last_contact,
                        "profile_id_a" => $profile_id_a,
                        "profile_id_b" => $profile_id_b
                    );

                    if ($item["profile_id_a"] == $profile->$id)
                    {
                        $furtherProfile = new Profile($connection);
                        $furtherProfile->$id = $item["profile_id_b"];
                        $furtherProfile->$state_id = 1; // 1 = infected

                        $furtherProfile->update();
                    }

                    if ($item["profile_id_b"] == $profile->$id)
                    {
                        $furtherProfile = new Profile($connection);
                        $furtherProfile->$id = $item["profile_id_a"];
                        $furtherProfile->$state_id = 1; // 1 = infected

                        $furtherProfile->update();
                    }
                }
            }
        }
    }
}

http_response_code(200);
echo json_encode($output);
?>
