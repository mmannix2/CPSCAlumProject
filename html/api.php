<?php
/*
Database connection info
$DB_HOST = "127.0.0.1";
$DB_USER = "api";
$DB_PASSWORD = "password";
$DB_NAME = "db";
*/

/*
api actions:
    get jobs
    post job
    post volunteer
    get announcements
admin actions: These require admin login and adminKey authentication
    delete job
    get volunteers
    delete volunteer
    post announcement
    delete announcement
*/

$ADMIN_KEY = 123456789;

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

/* Delete Function */
function deleteRow($table, $id) {
    try {
        $db = connectToDB('admin');
        
        $query = 'DELETE FROM ';
        $query .= $table;
        $query .= ' WHERE id = :id';
        
        //echo $query;
        
        $stmt = $db->prepare($query);
        //$stmt->bindParam(':table', $table, PDO::PARAM_STR, 13);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
         
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
        return json_encode(array("error" => "Failed to delete row " .$id ." of " .$table, "message" => $e.message));
    }
}

/* Get Functions */
function get($table) {
    try {
        //Connect to DB
        $db = connectToDB("api");
        
        $query = 'SELECT * FROM ';
        $query .= $table;
        
        //echo $query;
        
        //Get Result
        $results = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($results);
    }
    catch(PDOException $e) {
        return json_encode(array("error" => "Failed to load " .$table));
    }
}

function adminGet($table) {
    try {
        //Connect to DB
        $db = connectToDB("admin");
        
        $query = 'SELECT * FROM ';
        $query .= $table;
        
        //echo $query;
        
        //Get Result
        $results = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($results);
    }
    catch(PDOException $e) {
        return json_encode(array("error" => "Failed to load " .$table));
    }
}

/* Post Functions */
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
        return json_encode(array("status" => "code incomplete!"));
    }
    catch(PDOException $e) {
        return json_encode(array("error" => "Failed to search jobs."));
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
        
        $newId = $db->lastInsertId();
        
        return json_encode(array("success" => true));
    }
    catch(PDOException $e) {
        return json_encode(array("error" => "Failed to post volunteer.", "message" => $e.message));
    }
}

function postAnnouncement($postVolunteerInfo) {
    try {
        //Connect to DB
        $db = connectToDB('api');
        $query = "INSERT INTO announcements (title, description) VALUES (:title, :description)";
        
        //Insert this job into the DB
        $stmt = $db->prepare($query);
        $stmt->bindParam(':title', $postVolunteerInfo[title]);
        $stmt->bindParam(':description', $postVolunteerInfo[description]);
        $stmt->execute();
        
        $newId = $db->lastInsertId();
        
        return json_encode(array("success" => true));
    }
    catch(PDOException $e) {
        return json_encode(array("error" => "Failed to post announcement.", "message" => $e.message));
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

/* Authenticate adminKey */
function auth($ADMIN_KEY, $adminKey) {
    return $ADMIN_KEY == $adminKey;
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

$auth_token = 123456789;

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch($requestParts[2]) {
            //If looking for jobs or announcements, go ahead
            case 'jobs':
            case 'announcements':
                echo get($requestParts[2]);
            break;
            //If looking for volunteers, authenticate first
            case 'volunteers':
                if(auth($ADMIN_KEY, $auth_token)) {
                    echo 'Authentication successful.';
                    echo adminGet($requestParts[2]);
                }
                else {
                    echo 'Authentication failed.';
                    http_response_code(403);
                    return json_encode(array("success" => false));
                }
            break;
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        //These are all pretty unique, so they have their own functions
        switch($requestParts[2]) {
            //api/jobs
            case 'jobs':
                echo postJob($data);
            break;
            //api/volunteers
            case 'volunteers':
                echo postVolunteer($data);
            break;
            //api/announcements
            case 'announcements':
                //Authenticate first
                if(auth($ADMIN_KEY, $auth_token)) {
                    echo 'Authentication successful.';
                        echo postAnnouncement($data);
                }
                else {
                    echo 'Authentication failed.';
                    http_response_code(403);
                    return json_encode(array("success" => false));
                }
            break;
            //api/login
            case 'login':
                echo login($data, $ADMIN_KEY);
            break;
        }
        break;
    case 'DELETE':
        //Authenticate first
        if(auth($ADMIN_KEY, $auth_token)) {
            echo 'Authentication successful.';
            echo deleteRow($requestParts[2], $requestParts[3]);
        }
        else {
            echo 'Authentication failed.';
            http_response_code(403);
            return json_encode(array("success" => false));
        }
        break;
    default:
        echo json_encode(array("error" => "Unsupported method used."));
        break;
}

?>