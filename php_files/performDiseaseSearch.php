<! perform Search >
<! as the name implies, perform a search on the database, returning the results to the user >


<?php
// filepath: ./php_files/performSearch.php

// Include the database connection
include_once 'connectToDB.php';

try {
    // Get the search term from the POST request
    $searchTerm = $_POST['search'];

    // Prepare the SQL query with a WHERE clause
    $stmt = $conn->prepare("SELECT * FROM Disease WHERE DISEASE_NAME = :searchTerm;");
    $data = array(':searchTerm' => $searchTerm);
    
    $stmt->execute($data);

    // Set fetch mode to associative array
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    // Display results in a table
    echo "<table border='1'>";
    echo "<tr><th>Disease Name</th><th>Location</th><th>Type</th><th>Cure</th><th>First Case Date</th><th>Distribution Vector</th><th>Susceptible Population</th><th>Infected Population</th><th>Recovered Population</th><th>Year of Pull</th></tr>";

    while ($row = $stmt->fetch()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['DISEASE_NAME']) . "</td>";
        echo "<td>" . htmlspecialchars($row['LOCATION_OF_DATA']) . "</td>";
        echo "<td>" . htmlspecialchars($row['DISEASE_TYPE']) . "</td>";
        echo "<td>" . htmlspecialchars($row['DISEASE_CURE']) . "</td>";
        echo "<td>" . htmlspecialchars($row['FIRST_CASE_DATE']) . "</td>";
        echo "<td>" . htmlspecialchars($row['DISTRIBUTION_VECTOR']) . "</td>";
        echo "<td>" . htmlspecialchars($row['SUSCEPTABLE_POPULATION']) . "</td>";
        echo "<td>" . htmlspecialchars($row['INFECTED_POPULATION']) . "</td>";
        echo "<td>" . htmlspecialchars($row['RECOVERED_POPULATION']) . "</td>";
        echo "<td>" . htmlspecialchars($row['YEAR_OF_PULL']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>