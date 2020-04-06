<?php
header("Content-Type: application/json; charset=UTF-8"); // tells the client what the content type of the returned content actually is
header("Access-Control-Allow-Methods: POST"); // specifies the method or methods allowed when accessing the resource in response to a preflight request
header("Access-Control-Max-Age: 3600"); // indicates how long (in seconds) the results of a preflight request can be cached
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // indicates which HTTP headers can be used during the actual request

include_once "../configuration/database.php";
include_once "../entities/contact_controller.php";
include_once "../entities/profile_controller.php";
include_once "../entities/contact.php";
include_once "../entities/profile.php";

$httpResponseCode = 200;

$output = array();
$output["status_code"] = -1; // -1 = error

try
{
    $profileGuidA = $_GET["profile_guid_a"];
    $profileGuidB = $_GET["profile_guid_b"];

    if (isset($profileGuidA) && isset($profileGuidB) && !empty($profileGuidA) && !empty($profileGuidB))
    {
        $database = new Database();
        $connection = $database->getConnection();

        $profileController = new ProfileController($connection);

        // search for profile ID of profile A

        $profiles = $profileController->find($profileGuidA);
        $profileIdA = -1;

        foreach ($profiles as $profile)
        {
            $profileIdA = $profile->id;
        }

        // search for profile ID of profile B

        $profiles = $profileController->find($profileGuidB);
        $profileIdB = -1;

        foreach ($profiles as $profile)
        {
            $profileIdB = $profile->id;
        }

        // actual creation (or update) of the contact

        $contactController = new ContactController($connection);
        $contacts = $contactController->findByProfilePair($profileIdA, $profileIdB);

        if (count($contacts) == 0) // contact does not exist yet therefore create a new one
        {
            $contactController->create($profileIdA, $profileIdB);
        }
        else // contact already exists therefore just update it
        {
            foreach ($contacts as $contact)
            {
                $contactController->update($contact->id);
            }
        }

        $output["status_code"] = 0; // 0 = no error
    }
}
catch (Exception $exception)
{
    $httpResponseCode = 500;
}

http_response_code($httpResponseCode);
echo json_encode($output);
?>
