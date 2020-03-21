<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../entities/profile.php';
include_once '../entities/contact.php';

$data = json_decode(file_get_contents("php://input"));

if (empty($data->guid) || empty($data->passphrase) || empty($data->state_id))
{
    echo '{';
          echo '"status_code": -1';
    echo '}';
}
else
{
    $database = new Database();
    $connection = $database->getConnection();
    $profile = new Profile($connection);

    $profile->$guid = $data->guid;
    $profile->$passphrase = $data->passphrase;
    $profile->$state_id = $data->state_id;

    if ($profile->update())
    {
        echo '{';
            echo '"status_code": 0';
        echo '}';

        // TODO: use better solution
        if ($profile->$state_id == 1)
        {
            $contact = new Contact($connection);
            $statement = $contact->read();
            $count = $statement->rowCount();

            if ($count > 0)
            {
                while ($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    extract($row);

                    $item = array
                    (
                          "id" => $id,
                          "timestamp" => $timestamp,
                          "profile_id_a" => $profile_id_a,
                          "profile_id_b" => $profile_id_b
                    );

                    if ($item["profile_id_a"] == $profile->$id)
                    {
                        $furtherProfile = new Profile($connection);
                        $furtherProfile->$id = $item["profile_id_b"];
                        $furtherProfile->$state_id = 1;

                        $furtherProfile->update();
                    }
                    else if ($item["profile_id_b"] == $profile->$id)
                    {
                        $furtherProfile = new Profile($connection);
                        $furtherProfile->$id = $item["profile_id_a"];
                        $furtherProfile->$state_id = 1;

                        $furtherProfile->update();
                    }
                }
            }
        }
    }
    else
    {
        echo '{';
            echo '"status_code": -1';
        echo '}';
    }
}
?>
