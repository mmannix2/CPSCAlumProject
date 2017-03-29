<?php
/*
Database connection info
$DB_HOST = "127.0.0.1";
$DB_USER = "api";
$DB_PASSWORD = "password";
$DB_NAME = "db";
*/

$searchKeys = array("jobTitle", "companyName", "location");

function connectToDB() {
    $options = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION );
    return new PDO("mysql:host=127.0.0.1;dbname=db", "api", "password", $options);
}
 
/* Jobs */
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
    try {
        //Connect to DB
        $db = connectToDB();
        
        $query1 = "INSERT INTO jobs (jobTitle, companyName, description, location";
        $query2 = ") VALUES (:jobTitle, :companyName, :description, :location";
        
        if(array_key_exists("email", $postInfo)) {
            $query1 .= ", email";
            $query2 .= ", :email";
        }
        if(array_key_exists("link", $postInfo)) {
            $query1 .= ", link";
            $query2 .= ", :link";
        }
        
        $query = $query1 . $query2 . ")";
        
        //echo $query;
         
        //Insert this job into the DB
        $stmt = $db->prepare($query);
        
        //if(array_key_exists)
        
        $stmt->bindParam(':jobTitle', $postInfo[jobTitle]);
        $stmt->bindParam(':companyName', $postInfo[companyName]);
        $stmt->bindParam(':description', $postInfo[description]);
        $stmt->bindParam(':location', $postInfo[location]);
        
        if(array_key_exists("email", $postInfo)) {
            $stmt->bindParam(':email', $postInfo[email]);
        }
        if(array_key_exists("link", $postInfo)) {
            $stmt->bindParam(':link', $postInfo[link]);
        }
        
        $stmt->execute();
        
        $newId = $db->lastInsertId();
        //$stmt->close();
        
        return json_encode('"status":"success"');
    }
    catch(PDOException $e) {
        echo $e;
        return json_encode('"error":"Failed to post job."');
    }
}

function searchJobs($searchTerms) {
    $standardQuery = "SELECT name, companyName, location, description FROM jobs";
    $whereClause = " Where";
    try {
        $out = "";
        
        //Connect to DB
        $db = connectToDB();
        
        foreach($searchTerms as $key => $value) {
            $out .= "$key:$value/";
        }
        
        //Job Search Criteria
        /*
        For each key in $searchKeys:
            for each element in searchTerms:
                if element.key == this.key:
                    array[this.key] = element.value
                else:
                    array[this.key] = NULL
        */
        
        //foreach()
        
        //Get Search Results
        $results = $db->query('SELECT name, companyName, location, description FROM jobs')->fetchAll(PDO::FETCH_ASSOC);
        //return json_encode($results);
        
        return $out;
    }
    catch(PDOException $e) {
        return "<script>console.log(Connection Failed: $e</script>";
    }
}

/* Volunteers */
function postVolunteer($postInfo) {
    //TO DO INSERT this new volunteer into the db
    //Get data from POST
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

//Test Variables
$testSearchTerms = array("jobTitle" => "programmer", "companyName" => "TechCorp", "location" => "20169");

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        //api/jobs
        if( $requestParts[2] == "jobs") {
            echo loadJobs();
        }
        //api/jobs/search
        if( $requestParts[2] == "search") {
            echo searchJobs($testSearchTerms);
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        switch($requestParts[2]) {
            //api/jobs
            case 'jobs':
                /* Test Cases
                $postInfo1 = array( "jobTitle" => "Programmer", "companyName" => "TechCorp", "description" => "You will write code in C and C++.", "location" => 12345);
                $postInfo2 = array( "jobTitle" => "Programmer", "companyName" => "TechCorp", "description" => "You will write code in C and C++.", "location" => 12345, "email" => "boss@TechCorp.com");
                $postInfo3 = array( "jobTitle" => "Programmer", "companyName" => "TechCorp", "description" => "You will write code in C and C++.", "location" => 12345, "link" => "TechCorp.com/jobs/12345/1");
                $postInfo4 = array( "jobTitle" => "Programmer", "companyName" => "TechCorp", "description" => "You will write code in C and C++.", "location" => 12345, "email" => "boss@TechCorp.com", "link" => "TechCorp.com/jobs/12345/1");
                */
                echo postJob($data);
            break;
            case 'volunteers':
                echo postVolunteer();
            break;
        }
        echo var_dump($data);
        break;
    default:
        //echo "OTHER: $request";
        break;
}

?>