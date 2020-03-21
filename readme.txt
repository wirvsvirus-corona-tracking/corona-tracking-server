* api/
    * config/
        * setup.php: file used for setting up the database
        * database.php: file used for connecting to the database
        * data/
            * setup.sql: contains SQL statements for database setup
    * entities/
        * state.php: contains properties and methods for "state" database queries
        * profile.php: contains properties and methods for "profile" database queries
        * contact.php: contains properties and methods for "contact" database queries
    * states/
        * read.php: file that will accept posted "state" data to be saved to the database
    * profiles/
        * create.php: file that will accept posted "profile" data to be saved to the database
        * read.php: file that will output JSON data based on "profile" database records
        * read_one.php: file that will accept an ID to read a "profile" record from the database
        * update.php: file that will accept an ID to update a "profile" record from the database
        * delete.php: file that will accept an ID to delete a "profile" record from the database
    * contacts/
        * create.php: file that will accept posted "contact" data to be saved to the database
        * read.php: file that will accept posted "contact" data to be saved to the database
