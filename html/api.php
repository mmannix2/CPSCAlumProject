<?php
//Database connection info
    $DB_HOST = "127.0.0.1";
    $DB_USER = "api";
    $DB_PASSWORD = "password";
    $DB_NAME = "db";

    $API_KEYS = array("jobs", "volunteers", "announcements");

function checkAPIKey($parts, $API_KEYS) {
    if(in_array($parts[0], $API_KEYS)) {
        return true;
    }
    else {
        return false;
    }
}
    
function loadJobs($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME) {
    //Connect to DB
    try {
        $db = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
        
        //Get Result
        $results = $db->query('SELECT name, companyName, description FROM jobs')->fetchAll(PDO::FETCH_ASSOC);
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
        //TODO do error checking to ensure each api key supports the attempted request
        if( $requestParts[2] == "jobs") {
            echo loadJobs($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
        }
        if( $requestParts[2] == "search") {
            $json = json_encode("No results found.");
            echo $json;
        }
        break;
    case 'POST':
        $request = $_POST['request'];
        //echo "POST: $request";
        break;
    default:
        //echo "OTHER: $request";
        break;
}

/*
TODO Use the data that is parsed out ofthe request to run the correct SQL
statement on the DB.
*/
?>