<?php
header("Content-Type: application/json; charset=UTF-8"); // tells the client what the content type of the returned content actually is
header("Access-Control-Allow-Methods: PUT"); // specifies the method or methods allowed when accessing the resource in response to a preflight request
header("Access-Control-Max-Age: 3600"); // indicates how long (in seconds) the results of a preflight request can be cached
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // indicates which HTTP headers can be used during the actual request

include_once "../config/database.php";
include_once "../entities/profile_controller.php";
include_once "../entities/contact_controller.php";
include_once "../entities/profile.php";
include_once "../entities/contact.php";

$httpResponseCode = 200;

$output = array();
$output["status_code"] = -1; // -1 = error

try
{
    $guid = $_GET["guid"];
    $stateId = (int)$_GET["state_id"];

    if (isset($guid) && isset($stateId) && !empty($guid))
    {
        $database = new Database();
        $connection = $database->getConnection();

        $profileController = new ProfileController($connection);
        $profiles = $profileController->find($guid);

        foreach ($profiles as $profile)
        {
            $profileController->update($profile->id, $stateId);

            if ($stateId == 3) // 3 = infected
            {
                // the current profile was infected therefore update all profiles that had contact with the current profile

                $contactController = new ContactController($connection);
                $contacts = $contactController->findByProfile($profile->id);

                $otherProfiles = array();

                foreach ($contacts as $contact)
                {
                    if ($profile->id == $contact->profileIdA)
                    {
                        array_push($otherProfiles, $profileController->read($contact->profileIdB));
                    }
                    else
                    {
                        array_push($otherProfiles, $profileController->read($contact->profileIdA));
                    }
                }

                foreach ($otherProfiles as $otherProfile)
                {
                    // update the other profiles from "not infected" to "maybe infected"

                    if ($otherProfile->stateId == 1)  // 1 = not infected
                    {
                        $profileController->update($otherProfile->id, 2); // 2 = maybe infected
                    }
                }
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
