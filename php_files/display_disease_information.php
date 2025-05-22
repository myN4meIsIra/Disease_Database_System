<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disease Information</title>
    <link rel="stylesheet" href="../stylesheets/disease_details_stylesheet.css">

</head>

<body>

    <!-- header -->
    <header>
        <h1>Disease Database System</h1>
    </header>
    
    <!-- navbar-->
    <nav>
        <ul>
            <li><a href="../homepage.html">Home</a></li>
            <li><a href="../search.html">Search</a></li>
            <li><a href="../help.html">Help</a></li>
            <li><a href="upload.php">Upload</a></li>
            <li><a href="../delete.html">Delete</a></li>
            <li><a href="../export.html">Export</a></li>
            <li><a href="../contact.html">Contact</a></li>
            <li><a href='display_disease_information.php'>Diseases</a></li>
        </ul>
    </nav>


    <!-- main content -->
     <main>

     <?php

        // Include the database connection
        include_once 'connectToDB.php';

        global $conn;

            // Query to fetch disease details and their symptoms
            $stmt = $conn->prepare("
                SELECT 
                    Disease.DISEASE_NAME, 
                    Disease.DISEASE_TYPE, 
                    Disease.DISEASE_CURE, 
                    Symptom.SYMPTOM_NAME, 
                    Symptom.SYMPTOM_DESCRIPTION
                FROM Disease_Symptom
                INNER JOIN Disease ON Disease_Symptom.DISEASE_NAME = Disease.DISEASE_NAME
                INNER JOIN Symptom ON Disease_Symptom.SYMPTOM_NAME = Symptom.SYMPTOM_NAME
                ORDER BY Disease.DISEASE_NAME;
            ");
            $stmt->execute();

            // Fetch data as an associative array
            $diseaseDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);


            echo "<table border='1'>";
            echo "<tr><th>Disease Name</th><th>Disease Type</th><th>Disease Cure</th><th>Symptom Name</th><th>Symptom Description</th></tr>";   
            foreach ($diseaseDetails as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['DISEASE_NAME']) . "</td>";
                echo "<td>" . htmlspecialchars($row['DISEASE_TYPE']) . "</td>";
                echo "<td>" . htmlspecialchars($row['DISEASE_CURE']) . "</td>";
                echo "<td>" . htmlspecialchars($row['SYMPTOM_NAME']) . "</td>";
                echo "<td>" . htmlspecialchars($row['SYMPTOM_DESCRIPTION']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";

        // Close the connection
        $conn = null;
        ?>

        <h2>Search for a Disease</h2>
        <form action="fullDiseaseLookup.php" method="post">
            <input type="text" name="search" placeholder="Enter disease name or symptom...">
            <input type="submit" value="Search">
        </form>
     </main>


    <!--footer-->
    <footer>
        <p>Applied Databases Group Project 2025 </p>
    </footer>
</body>
</html>
