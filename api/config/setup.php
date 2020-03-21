<?
include_once './database.php';

try
{
  $database = new Database();
  $connection = $database.getConnection();
  $sql_script = file_get_contents("data/setup.sql");

  $connection->exec($sql_script);

  echo "Database and tables were created.";
}
catch(PDOException $exception)
{
    echo "Database and tables were NOT created.";
    echo "ERROR: " . $$exception->getMessage();
}
?>
