<?php
//Database connection info
    $DB_HOST = "127.0.0.1";
    $DB_USER = "api";
    $DB_PASSWORD = "password";
    $DB_NAME = "db";
    
//Get the api keys
switch($_SERVER['REQUEST_METHOD'])
{
    case 'GET': $request = $_GET['request']; break;   
    case 'POST': $request = $_POST['request']; break;   
}

//Connect to DB
try {
    $db = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    
    //Get Result
    $results = $db->query('SELECT name, companyName, description FROM jobs')->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($results);
    return $json;
}
catch(PDOException $e) {
    echo "<script>console.log(Connection Failed: $e->getMessage())</script>";
}

#echo $request;
/*
TODO Use the data that is parsed out ofthe request to run the correct SQL
statement on the DB.
*/
?>