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

    echo "<h2>Search Results for: " . htmlspecialchars($searchTerm) . "</h2>";

    // Prepare the SQL query with a WHERE clause
    $stmt = $conn->prepare("SELECT * FROM Disease WHERE DISEASE_NAME = :searchTerm;");
    $data = array(':searchTerm' => $searchTerm);
    
    $stmt->execute($data);

    // Set fetch mode to associative array
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    echo "<h3><br><br>Disease Details</h3>";

    // Display results in a table
    echo "<table border='0'>";
    echo "<tr><th>Disease Name</th><th>Location</th><th>Type</th><th>Cure</th><th>First Case Date</th><th>Distribution Vector</th><th>Susceptible Population</th><th>Infected Population</th><th>Recovered Population</th><th>Year of Pull</th></tr>";

    while ($row = $stmt->fetch()) {
        echo "<tr>";
        echo "<td>|" . htmlspecialchars($row['DISEASE_NAME']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['LOCATION_OF_DATA']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['DISEASE_TYPE']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['DISEASE_CURE']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['FIRST_CASE_DATE']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['DISTRIBUTION_VECTOR']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['SUSCEPTABLE_POPULATION']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['INFECTED_POPULATION']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['RECOVERED_POPULATION']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['YEAR_OF_PULL']) . "|</td>";
        echo "</tr>";
    }
    echo "</table>";

    
    // Pull symptoms related to the disease
    $stmt = $conn->prepare("
        SELECT 
            Symptom.SYMPTOM_NAME, 
            Symptom.SYMPTOM_DESCRIPTION
        FROM Disease_Symptom
        INNER JOIN Disease ON Disease_Symptom.DISEASE_NAME = Disease.DISEASE_NAME
        INNER JOIN Symptom ON Disease_Symptom.SYMPTOM_NAME = Symptom.SYMPTOM_NAME
        WHERE Disease.DISEASE_NAME = :searchTerm;");
    $stmt->execute($data);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    echo "<h3><br><br>Symptoms</h3>";
    echo "<table border='0'>";
    echo "<tr><th>Symptom Name</th><th>Symptom Description</th></tr>";  
    while ($row = $stmt->fetch()) {
        echo "<tr>";
        echo "<td>|" . htmlspecialchars($row['SYMPTOM_NAME']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['SYMPTOM_DESCRIPTION']) . "|</td>";
        echo "</tr>";
    }
    echo "</table>";

    
    // pull outbreak data related to the disease
    $stmt = $conn->prepare("
        SELECT 
            *
        FROM Outbreak
        WHERE Outbreak.DISEASE_NAME = :searchTerm;");
    $stmt->execute($data);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    echo "<h3><br><br>Outbreak Data</h3>";
    echo "<table border='0'>";
    //  OUTBREAK_ID | DATE_REPORTED | CASE_COUNT | DEATH_COUNT | RECOVERY_COUNT | DISEASE_NAME | REGION_NAME 
    echo "<tr><th>Outbreak ID</th>  <th>Date Reported</th>  <th>Case Count</th>  <th>Death Count</th>  <th>Recovery Count</th>  <th>Region Name</th>  </tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>";
        echo "<td>|" . htmlspecialchars($row['OUTBREAK_ID']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['DATE_REPORTED']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['CASE_COUNT']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['DEATH_COUNT']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['RECOVERY_COUNT']) . "|</td>";
        echo "<td>|" . htmlspecialchars($row['REGION_NAME']) . "|</td>";
        echo "</tr>";
    }
    echo "</table>";


    // pull pathogen data related to the disease
    $stmt = $conn->prepare("
         select * 
         from Pathogen, Disease_Pathogen 
         where Pathogen.PATHOGEN_NAME=Disease_Pathogen.PATHOGEN_NAME 
            and Disease_Pathogen.DISEASE_NAME = :searchTerm;");
    $stmt->execute($data);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    echo "<h3><br><br>Pathogen Data (how it's spread)</h3>";
    echo "<table border='0'>";  
    // PATHOGEN_NAME | SPREAD_EFFICIENCY | DENSITY_OF_PATHOGEN | DISEASE_NAME | PATHOGEN_NAME
    echo "<tr><th>Pathogen Name</th>  <th>Spread Efficency</th>  <th>Density of Pathogen</th></tr>";
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

