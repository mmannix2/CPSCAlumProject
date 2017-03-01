<?php
    //Database connection info
    $DB_HOST = "127.0.0.1";
    $DB_USER = "api";
    $DB_PASSWORD = "password";
    $DB_NAME = "db";
    
    try {
        $db = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
        #$stmt = $db->prepare("SELECT * FROM jobs;");
        
        #$stmt->execute();
        
        $results = $db->query('SELECT name, companyName, description FROM jobs')->fetchAll(PDO::FETCH_ASSOC);
        $json = json_encode($results);
        echo $json;
        return 0;
    }
    catch(PDOException $e) {
        echo "<script>console.log(Connection Failed: $e->getMessage())</script>";
        return 1;
    }
?>