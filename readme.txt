* api/
    * configuration/
        * setup.php: file used for setting up the database
        * cleanup.php: file used for cleaning up the database
        * database.php: file used for connecting to the database
        * data/
            * database_credentials.php: contains a PHP array with the database credentials
            * database_setup.sql: contains SQL statements for the database setup
            * database_cleanup.sql: contains SQL statements for the database cleanup
    * entities/
        * state.php: contains the "state" properties
        * profile.php: contains the "profile" properties
        * contact.php: contains the "contact" properties
    * controllers/
        * state_controller.php: contains the methods for the "state" related database queries
        * profile_controller.php: contains the methods for the "profile" related database queries
        * contact_controller.php: contains the methods for the "contact" related database queries
    * states/
        * read_all.php: file that will read and output all the "states"
    * profiles/
        * create.php: file that will create a new "profile"
        * read.php: file that will read and output a specific "profile"
        * read_all.php: file that will read and output all the "profiles"
        * update.php: file that will update a specific "profile"
        * delete.php: file that will delete a specific "profile"
    * contacts/
        * create.php: file that will create a new "contact"
        * read_all.php: file that will read and output all the "contacts"
