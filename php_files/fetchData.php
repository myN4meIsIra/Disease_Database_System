<?php
// filepath: ./php_files/fetchData.php

// Include the database connection
include_once 'connectToDB.php';
global $conn;
try {
    // Query to fetch data
    $stmt = $conn->prepare("SELECT * FROM Disease;");
    $stmt->execute();

    // Fetch data as an associative array
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return data as JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

// Close the connection
$conn = null;
?>