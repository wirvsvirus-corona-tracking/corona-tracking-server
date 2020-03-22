<?
include_once './database.php';

try
{
    $database = new Database();
    $connection = $database.getConnection();
    $setup_script = file_get_contents("data/setup.sql");

    $connection->exec($setup_script);

    echo "Setting up the tables succeeded.";
}
catch(PDOException $exception)
{
    echo "Setting up the tables failed with the following error message: '" . $$exception->getMessage() . "'.";
}
?>
