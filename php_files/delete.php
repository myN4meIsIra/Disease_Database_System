<!-- Delete -->
<!---- Delete data from some tables -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
    <link rel="stylesheet" href="../stylesheets/export_stylesheet.css">
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
            include_once 'connectToDB.php';
            global $conn;

            try {

                // Get the search term from the POST request
                $checkTable = $_POST['table'];

                echo "<h2>Search Results for table: " . htmlspecialchars($checkTable) . "</h2>";

                // Prepare the SQL query with a WHERE clause
                $stmt = $conn->prepare("SELECT * FROM $checkTable;");
                $data = array(':searchTerm' => $searchTerm);
                
                $stmt->execute($data);

                // Set fetch mode to associative array
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                
                echo "<h3><br><br>Select which rows you would like to delete</h3>";
                
                echo "<form  id=deleteForm action='deleteRows.php' method='post'>";
                echo "<input type='hidden' name='table' value='" . htmlspecialchars($checkTable) . "'>";

                // Display results in a table
                echo "<table border='0'>";

                // Get the column names
                $columns = array();
                for ($i = 0; $i < $stmt->columnCount(); $i++) {
                    $meta = $stmt->getColumnMeta($i);
                    $columns[] = $meta['name'];
                }
                
                // Print the column names
                echo "<tr>";
                echo "<th></th>"; // empty column
                foreach ($columns as $column) {
                    echo "<th>" . htmlspecialchars($column) . "</th>";
                }
                echo "</tr>";

    
                // Print the data as checkbox row
                while ($row = $stmt->fetch()) {
                    echo "<tr>";     
                    echo "<td><input type='checkbox' name='delete[]' value='" . htmlspecialchars($row[$columns[0]]) . "'></td>";               
                    foreach ($columns as $column) {
                        echo "<td>" . htmlspecialchars($row[$column]) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
                
                echo "<button type='submit'>Delete Selected Rows</button>";
               
                echo "</form>";

            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            // Close the connection
            $conn = null;

        ?>
    </main>

    <!--footer-->
    <footer>
        <p>Applied Databases Group Project 2025 </p>
    </footer>
</body>
</html>

