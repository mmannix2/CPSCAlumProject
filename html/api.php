<?php
/*
Database connection info
$DB_HOST = "127.0.0.1";
$DB_USER = "api";
$DB_PASSWORD = "password";
$DB_NAME = "db";
*/

function connectToDB() {
    return new PDO("mysql:host=127.0.0.1;dbname=db", "api", "password");
}
 
function loadJobs() {
    try {
        //Connect to DB
        $db = connectToDB();
        
        //Get Result
        $results = $db->query('SELECT name, companyName, location, description FROM jobs')->fetchAll(PDO::FETCH_ASSOC);
        $json = json_encode($results);
        return $json;
    }
    catch(PDOException $e) {
        return "<script>console.log(Connection Failed: $e</script>";
    }
}

function postJob($postInfo) {
    //TO DO INSERT this new job into the db
    //Get data from POST
}

function searchJobs($query) {
    //TO DO Write specific SELECT statements to search
}

function loadVolunteers() {
    try {
        //Connect to DB
        $db = connectToDB();
        
        //Get Result
        $results = $db->query('SELECT * FROM volunteers')->fetchAll(PDO::FETCH_ASSOC);
        $json = json_encode($results);
        return $json;
    }
    catch(PDOException $e) {
        return "<script>console.log(Connection Failed: $e</script>";
    }
}

//Get the request
$requestURI = $_SERVER['REQUEST_URI'];
$requestParts = explode('/', rtrim($requestURI, '/'));

switch($_SERVER['REQUEST_METHOD'])
{
    case 'GET':
        if( $requestParts[2] == "jobs") {
            echo loadJobs();
        }
        if( $requestParts[2] == "search") {
            $json = json_encode("No results found.");
            echo $json;
        }
        break;
    case 'POST':
        $request = $_POST['request'];
        break;
    default:
        //echo "OTHER: $request";
        break;
}

?>