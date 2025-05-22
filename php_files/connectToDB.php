<?php
// access and credential information 
$host = "pluto.hood.edu";
$dbname = "database_name"; // replace with your database name
$user = "username"; // replace with your username
$pass = "password"; // replace with your password

// try to connect to the database. On failure, die with an error message
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>