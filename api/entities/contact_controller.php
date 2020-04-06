<?php
include_once "contact.php";

class ContactController
{
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function create($profileIdA, $profileIdB)
    {
        $query = "INSERT INTO contact (profile_id_a, profile_id_b)
                  VALUES (" . $profileIdA . ", " . $profileIdB . ")";

        $this->executeQuery($query);
    }

    public function read($id)
    {
        $query = "SELECT id, last_contact, profile_id_a, profile_id_b
                  FROM contact
                  WHERE id = " . $id;

        $statement = $this->executeQuery($query);
        $contacts = ContactController::fetchContacts($statement);

        return $contacts;
    }

    public function readAll()
    {
        $query = "SELECT id, last_contact, profile_id_a, profile_id_b
                  FROM contact";

        $statement = $this->executeQuery($query);
        $contacts = ContactController::fetchContacts($statement);

        return $contacts;
    }

    public function update($id)
    {
        $query = "UPDATE contact
                  SET last_contact = CURRENT_TIMESTAMP
                  WHERE id = " . $id;

        $this->executeQuery($query);
    }

    public function findByProfile($profileId)
    {
        $query = "SELECT id, last_contact, profile_id_a, profile_id_b
                  FROM contact
                  WHERE profile_id_a = " . $profileId . " OR profile_id_b = " . $profileId;

        $statement = $this->executeQuery($query);
        $contacts = ContactController::fetchContacts($statement);

        return $contacts;
    }

    public function findByProfilePair($profileIdA, $profileIdB)
    {
        $query = "SELECT id, last_contact, profile_id_a, profile_id_b
                  FROM contact
                  WHERE (profile_id_a = " . $profileIdA . " AND profile_id_b = " . $profileIdB . ") OR (profile_id_a = " . $profileIdB . " AND profile_id_b = " . $profileIdA . ")";

        $statement = $this->executeQuery($query);
        $contacts = ContactController::fetchContacts($statement);

        return $contacts;
    }

    private function executeQuery($query)
    {
        $statement = $this->connection->prepare($query);
        $statement->execute();

        //print_r($statement->errorInfo());

        return $statement;
    }

    private static function fetchContacts($statement)
    {
        $contacts = array();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
            $contact = new Contact();
            $contact->id = $row["id"];
            $contact->lastContact = $row["last_contact"];
            $contact->profileIdA = $row["profile_id_a"];
            $contact->profileIdB = $row["profile_id_b"];

            array_push($contacts, $contact);
        }

        return $contacts;
    }

    // database connection
    private $connection;
}
?>
