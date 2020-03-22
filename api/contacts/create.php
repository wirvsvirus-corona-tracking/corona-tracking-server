<?
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../entities/contact.php';
include_once '../entities/profile.php';

$data = json_decode(file_get_contents("php://input"));

$output = array();
$output["status_code"] = -1; // -1 = error

if (!empty($data->profile_guid_a) &&
    !empty($data->profile_guid_b))
{
    $database = new Database();
    $connection = $database->getConnection();

    $contact = new Contact($connection);

    // search for profile ID of profile A

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

    // search for profile ID of profile B

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

    // actual creation (or update) of the contact

    $statement = $contact->find();
    $count = $statement->rowCount();

    if ($count > 0) // contact already exists therefore just update the contact
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

            $contact->id = $item["id"];
        }

        if ($contact->update())
        {
            $output["status_code"] = 0; // 0 = no error
        }
    }
    else // contact does not exist yet therefore create a new contact
    {
        if ($contact->create())
        {
            $output["status_code"] = 0; // 0 = no error
        }
    }
}

http_response_code(200);
echo json_encode($output);
?>
