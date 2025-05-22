<?php
// Database connection info

include_once 'connectToDB.php';
global $conn;


global $conn;
try {

    // (B) CREATE EMPTY CSV FILE ON SERVER
    // Set headers for file download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="export.csv"');

    // Open output stream for writing directly to the browser
    $output = fopen('php://output', 'w');
    if ($output === false) {
        exit("Error creating output stream");
    }

    // create headers
    $tables = ['Disease', 'Disease_Pathogen', 'Disease_Symptom', 'Healthcare_Provider', 'Outbreak', 'Pathogen', 'Patient', 'Patient_Pathogen_Contact', 'Symptom'];

    foreach ($tables as $individualTable){
        $stmt = $conn->prepare("SELECT * FROM $individualTable;");
        $stmt->execute();

        // Fetch data as an associative array
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Write the header row
        fputcsv($output, array_keys($data[0]));
        // Write the data rows
        foreach ($data as $row) {
            fputcsv($output, $row);
        }

        fputcsv($output, []); // empty line 
        
    }


    fclose($handle);
    echo "End of Export";

    // Return data as JSON
    //echo json_encode($data, JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

// Close the connection
$conn = null;
?>

