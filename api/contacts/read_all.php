<?
header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../entities/contact.php';

$database = new Database();
$connection = $database->getConnection();

$contact = new Contact($connection);

$statement = $contact->readAll();
$count = $statement->rowCount();

$output = array();
$output["count"] = 0;
$output["body"] = array();

if ($count > 0)
{
    $output["count"] = $count;

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

        array_push($output["body"], $item);
    }
}

http_response_code(200);
echo json_encode($output);
?>
