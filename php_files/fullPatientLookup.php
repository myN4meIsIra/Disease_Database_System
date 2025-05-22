<! perform Search >
<! as the name implies, perform a search on the database, returning the results to the user >

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Search with 3D Chart</title>
    <link rel="stylesheet" href="../stylesheets/search_stylesheet.css">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<body>
    <!-- header -->
    <header>
        <h1>Disease Database System</h1>
    </header>
    
    <!-- navbar -->
    <nav>
        <ul>
            <li><a href="../homepage.html">Home</a></li>
            <li><a href="../search.html">Search</a></li>
            <li><a href="../help.html">Help</a></li>
            <li><a href="../export.html">Export</a></li>
        </ul>
    </nav>

    <main>
<?php
// filepath: ./php_files/performSearch.php

// Include the database connection
include_once 'connectToDB.php';

try {

    // Get the search term from the POST request
    $searchTerm = $_POST['search'];

    echo "<h2>Search Results for Patient: " . htmlspecialchars($searchTerm) . "</h2>";

    // Prepare the SQL query with a WHERE clause
    $stmt = $conn->prepare("SELECT * FROM Patient WHERE PATIENT_ID = :searchTerm;");
    $data = array(':searchTerm' => $searchTerm);
    
    $stmt->execute($data);

    // Set fetch mode to associative array
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
    echo "<h3><br><br>Patient Details</h3>";

    // Display results in a table
    echo "<table border='0'>";
    //PATIENT_ID | PATIENT_NAME | DOB        | PATIENT_INFECTION_STATUS | TREATMENT_NAME | TREATMENT_EFFECTIVENESS
    echo "<tr><th>Patient ID</th><th>Patient Name</th><th>DOB</th><th>Infection Status</th><th>Treatment Name</th><th>Treatment Effectiveness</th></tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>";
        echo "<td>|" . htmlspecialchars($row['PATIENT_ID']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['PATIENT_NAME']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['DOB']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['PATIENT_INFECTION_STATUS']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['TREATMENT_NAME']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['TREATMENT_EFFECTIVENESS']) . "|</td>";
        echo "</tr>";
    }
    echo "</table>";


    // show patient pathogen contact
    echo "<h3><br><br>Patient Pathogen Contact</h3>";
    $stmt = $conn->prepare("
        SELECT 
            *
        FROM Patient_Pathogen_Contact, Pathogen
        WHERE Pathogen.PATHOGEN_NAME = Patient_Pathogen_Contact.PATHOGEN_NAME and Patient_Pathogen_Contact.PATIENT_ID = :searchTerm;");
    $data = array(':searchTerm' => $searchTerm);
    $stmt->execute($data);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    echo "<table border='0'>";
    // | PATHOGEN_NAME | PATHOGEN_NAME | SPREAD_EFFICIENCY | DENSITY_OF_PATHOGEN |
    echo "<tr><th>Pathogen Name</th><th>Spread Efficiency</th><th>Density of Pathogen</th></tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>";
        echo "<td>|" . htmlspecialchars($row['PATHOGEN_NAME']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['SPREAD_EFFICIENCY']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['DENSITY_OF_PATHOGEN']) . "|</td>";
        echo "</tr>";
    }
    echo "</table>";

    


} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>

</main>


   <!-- Footer -->
   <footer>
        <p>Applied Databases Group Project 2025</p>
    </footer>

