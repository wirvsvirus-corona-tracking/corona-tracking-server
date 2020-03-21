<?
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../entities/contact.php';

$database = new Database();
$connection = $database->getConnection();
$contact = new Contact($connection);

$statement = $contact->read();
$count = $statement->rowCount();

if ($count > 0)
{
    $contacts = array();
    $contacts["body"] = array();
    $contacts["count"] = $count;

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

        array_push($contacts["body"], $item);
    }

    http_response_code(200);

    echo json_encode($contacts);
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
