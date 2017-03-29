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
function getJobs() {
    try {
        //Connect to DB
        $db = connectToDB();
        
        //Get Result
        $results = $db->query('SELECT jobTitle, companyName, location, description FROM jobs')->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($results);
    }
    catch(PDOException $e) {
        return json_encode(array("error" => "Failed to load jobs."));
    }
}

function postJob($postJobInfo) {
    try {
        //Connect to DB
        $db = connectToDB();
        
        $query1 = "INSERT INTO jobs (jobTitle, companyName, description, location";
        $query2 = ") VALUES (:jobTitle, :companyName, :description, :location";
        
        if(array_key_exists("email", $postJobInfo)) {
            $query1 .= ", email";
            $query2 .= ", :email";
        }
        if(array_key_exists("link", $postJobInfo)) {
            $query1 .= ", link";
            $query2 .= ", :link";
        }
        
        $query = $query1 . $query2 . ")";
        
        echo $query;
         
        //Insert this job into the DB
        $stmt = $db->prepare($query);
        
        //if(array_key_exists)
        
        $stmt->bindParam(':jobTitle', $postJobInfo[jobTitle]);
        $stmt->bindParam(':companyName', $postJobInfo[companyName]);
        $stmt->bindParam(':description', $postJobInfo[description]);
        $stmt->bindParam(':location', $postJobInfo[location]);
        
        if(array_key_exists("email", $postJobInfo)) {
            $stmt->bindParam(':email', $postJobInfo[email]);
        }
        if(array_key_exists("link", $postJobInfo)) {
            $stmt->bindParam(':link', $postJobInfo[link]);
        }
        
        $stmt->execute();
        
        $newId = $db->lastInsertId();
        //$stmt->close();
        
        return json_encode(array("success" => true));
    }
    catch(PDOException $e) {
        return json_encode(array("error" => "Failed to post jobs.", "e" => $e));
    }
}

function searchJobs($searchTerms) {
    try {
    //Connect to DB
    $db = connectToDB();
    /*
    $standardQuery = "SELECT name, companyName, location, description FROM jobs";
    $whereClause = " Where";
        $out = "";
        
        
        foreach($searchTerms as $key => $value) {
            $out .= "$key:$value/";
        }
    */    
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
        //$results = $db->query('SELECT name, companyName, location, description FROM jobs')->fetchAll(PDO::FETCH_ASSOC);
        //return json_encode($results);
        
        //return $out;
        return json_encode(array("status" => "code incomplete!"));
    }
    catch(PDOException $e) {
        return json_encode(array("error" => "Failed to search jobs."));
    }
}

/* Volunteers */
function postVolunteer($postVolunteerInfo) {
    //TO DO INSERT this new volunteer into the db
    //Get data from POST
}

function getVolunteers() {
    try {
        //Connect to DB
        $db = connectToDB();
        
        //Get Result
        $results = $db->query('SELECT name, email, description FROM volunteers')->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($results);
    }
    catch(PDOException $e) {
        return json_encode(array("error" => "Failed to load volunteers."));
    }
}

//Get the request
$requestURI = $_SERVER['REQUEST_URI'];
$requestParts = explode('/', rtrim($requestURI, '/'));

/* Test Cases
//searchJobs
$searchJobs1 = array("jobTitle" => "programmer", "companyName" => "TechCorp", "location" => "20169");

//postJob
$postJob1 = array( "jobTitle" => "Programmer", "companyName" => "TechCorp", "description" => "You will write code in C and C++.", "location" => 12345);
$postJob2 = array( "jobTitle" => "Programmer", "companyName" => "TechCorp", "description" => "You will write code in C and C++.", "location" => 12345, "email" => "boss@TechCorp.com");
$postJob3 = array( "jobTitle" => "Programmer", "companyName" => "TechCorp", "description" => "You will write code in C and C++.", "location" => 12345, "link" => "TechCorp.com/jobs/12345/1");
$postJob4 = array( "jobTitle" => "Programmer", "companyName" => "TechCorp", "description" => "You will write code in C and C++.", "location" => 12345, "email" => "boss@TechCorp.com", "link" => "TechCorp.com/jobs/12345/1");
*/

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch($requestParts[2]) {
            //api/jobs
            case 'jobs':
                echo getJobs();
            break;
            //api/search
            case 'search':
                echo searchJobs($testSearchTerms);
            break;
            //api/volunteers 
            case 'volunteers':
                echo getVolunteers();
            break;
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        switch($requestParts[2]) {
            //api/jobs
            case 'jobs':
                echo postJob($data);
            break;
            case 'volunteers':
                echo postVolunteer($data);
            break;
        }
        echo var_dump($data);
        break;
    default:
        echo json_encode(array("error" => "Unsupported method used."));
        break;
}

?>