<?php
/*
Database connection info
$DB_HOST = "127.0.0.1";
$DB_USER = "api";
$DB_PASSWORD = "password";
$DB_NAME = "db";
*/

$ADMIN_KEY = NULL;

$searchKeys = array("jobTitle", "companyName", "location");

function connectToDB($user) {
    $options = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION );
    switch($user) {
        case 'api':
            return new PDO("mysql:host=127.0.0.1;dbname=db", "api", "password", $options);
        break;
        case 'admin':
            return new PDO("mysql:host=127.0.0.1;dbname=db", "admin", "admin", $options); //For whatever reason, admin doesn't like to use a password
        break;
    }
}
 
/* Jobs */
function getJobs() {
    try {
        //Connect to DB
        $db = connectToDB("api");
        
        //Get Result
        $results = $db->query('SELECT * FROM jobs')->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($results);
    }
    catch(PDOException $e) {
        return json_encode(array("error" => "Failed to load jobs."));
    }
}

function postJob($postJobInfo) {
    try {
        //Connect to DB
        $db = connectToDB('api');
        
        $query1 = "INSERT INTO jobs (jobTitle, companyName, description, location";
        $query2 = ") VALUES (:jobTitle, :companyName, :description, :location";
        
        if(!empty($postJobInfo[email])) {
            $query1 .= ", email";
            $query2 .= ", :email";
        }
        if(!empty($postJobInfo[link])) {
            $query1 .= ", link";
            $query2 .= ", :link";
        }
        
        $query = $query1 . $query2 . ")";
        
        //echo $query;
         
        //Insert this job into the DB
        $stmt = $db->prepare($query);
        
        //if(array_key_exists)
        
        $stmt->bindParam(':jobTitle', $postJobInfo[jobTitle]);
        $stmt->bindParam(':companyName', $postJobInfo[companyName]);
        $stmt->bindParam(':description', $postJobInfo[description]);
        $stmt->bindParam(':location', $postJobInfo[location]);
        
        if(!empty($postJobInfo[email])) {
            $stmt->bindParam(':email', $postJobInfo[email]);
        }
        if(!empty($postJobInfo[link])) {
            $stmt->bindParam(':link', $postJobInfo[link]);
        }
        
        $stmt->execute();
        
        $newId = $db->lastInsertId();
        //$stmt->close();
        
        return json_encode(array("success" => true));
    }
    catch(PDOException $e) {
        return json_encode(array("error" => "Failed to post job.", "message" => $e.message));
    }
}

function searchJobs($searchTerms) {
    try {
    //Connect to DB
    $db = connectToDB('api');
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

function deleteJob($jobNumber) {
    try {
        //Connect to DB
        $db = connectToDB('admin');
        
        //Get Result
        $stmt = $db->prepare('DELETE FROM jobs WHERE id = :jobNumber');
        $stmt->bindParam(':jobNumber', $jobNumber);
         
        $stmt->execute();
        
        if($stmt->rowCount() == 0) {
            http_response_code(404);
            return json_encode(array("success" => false));
        }
        else {
            http_response_code(200);
            return json_encode(array("success" => true));
        }
    }
    catch(PDOException $e) {
        return json_encode(array("error" => "Failed to delete job.", "message" => $e.message));
    }
}

/* Volunteers */
function getVolunteers() {
    try {
        //Connect to DB
        $db = connectToDB('api');
        
        //Get Result
        $results = $db->query('SELECT * FROM volunteers')->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($results);
    }
    catch(PDOException $e) {
        return json_encode(array("error" => "Failed to load volunteers."));
    }
}

function postVolunteer($postVolunteerInfo) {
    try {
        //Connect to DB
        $db = connectToDB('api');
        $query = "INSERT INTO volunteers (name, email, description) VALUES (:name, :email, :description)";
        
        //Insert this job into the DB
        $stmt = $db->prepare($query);
        $stmt->bindParam(':name', $postVolunteerInfo[name]);
        $stmt->bindParam(':email', $postVolunteerInfo[email]);
        $stmt->bindParam(':description', $postVolunteerInfo[description]);
        $stmt->execute();
        
        echo $query;
        
        $newId = $db->lastInsertId();
        
        return json_encode(array("success" => true));
    }
    catch(PDOException $e) {
        return json_encode(array("error" => "Failed to post volunteer.", "message" => $e.message));
    }
}

function deleteVolunteer($volunteerNumber) {
    try {
        //Connect to DB
        $db = connectToDB('admin');
        
        //Get Result
        $stmt = $db->prepare('DELETE FROM volunteers WHERE id = :volunteerNumber');
        $stmt->bindParam(':volunteerNumber', $volunteerNumber);
         
        $stmt->execute();
        
        if($stmt->rowCount() == 0) {
            http_response_code(404);
            return json_encode(array("success" => false));
        }
        else {
            http_response_code(200);
            return json_encode(array("success" => true));
        }
    }
    catch(PDOException $e) {
        return json_encode(array("error" => "Failed to delete volunteer.", "message" => $e.message));
    }
}

/* Announcements */
function getAnnouncements() {
    try {
        //Connect to DB
        $db = connectToDB("api");
        
        //Get Result
        $results = $db->query('SELECT * FROM announcements')->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($results);
    }
    catch(PDOException $e) {
        echo $e;
        return json_encode(array("error" => "Failed to load announcements."));
    }
}

/* Admin Login */
function login($loginInfo) {
    if( strcasecmp($loginInfo[username], "admin") == 0 && strcmp($loginInfo[password], "admin") == 0 ) {
        //Generate a secret key and pass it to the user.
        if($ADMIN_KEY == NULL) {
            $ADMIN_KEY = "123456789"; //Use some bassass hash or something
        }
        http_response_code(200);
        return json_encode(array("adminKey" => $ADMIN_KEY));
    }
    else {
        http_response_code(403);
        return json_encode(array("status" => "failure"));
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
            //api/volunteers //Requires Admin login
            case 'volunteers':
                echo getVolunteers();
            break;
            //api/announcements
            case 'announcements':
                echo getAnnouncements();
            break;
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        //echo var_dump($data);
        switch($requestParts[2]) {
            //api/jobs
            case 'jobs':
                echo postJob($data);
            break;
            //api/volunteers
            case 'volunteers':
                echo postVolunteer($data);
            break;
            //api/login
            case 'login':
                echo login($data, $ADMIN_KEY);
            break;
        }
        break;
    case 'DELETE':
        echo $requestParts[3];
        //Delete rows from the database be id number
        switch($requestParts[2]) {
            //api/jobs/X
            case 'jobs':
                echo deleteJob($requestParts[3]);
            break;
            //api/volunteers/X
            case 'volunteers':
                echo deleteVolunteer($requestParts[3]);
            break;
        }
        break;
    default:
        echo json_encode(array("error" => "Unsupported method used."));
        break;
}

?>