 <?php
            // connect to database
            include_once 'connectToDB.php';
            global $conn;

            // push the post data into variables
            if(isset($_POST['delete'])) {
                $rowsToDelete = $_POST['delete'];
            } else {
                $rowsToDelete = [];
            }

            if(isset($_POST['table'])) {
                $checkTable = $_POST['table'];
            } else {
                $checkTable = '';
            }

            try {

                // Get the search term from the POST request
                echo "<h2>Search Results for table: " . htmlspecialchars($checkTable) . "</h2>";

                foreach ($rowsToDelete as $row) {
                    echo "<h3>Row to be deleted: " . htmlspecialchars($row) . "</h3>";

                     // PULL column names
                    $stmt = $conn->prepare("SELECT * FROM $checkTable;");                    
                    $stmt->execute($data);

                    // Set fetch mode to associative array
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);

                    // Get the column names -- the first column is the primary key, so use it for deletion
                    $columns = array();
                    for ($i = 0; $i < $stmt->columnCount(); $i++) {
                        $meta = $stmt->getColumnMeta($i);
                        $columns[] = $meta['name'];
                    }

                     echo "<p> column to be deleted: " . htmlspecialchars($columns[0]) . "</p>";
                   
                     // stop foreign key checks
                     $conn->exec("SET FOREIGN_KEY_CHECKS = 0;");

                    $stmt = $conn->prepare("DELETE FROM $checkTable WHERE $columns[0] = :row;");
                    $stmt->bindParam(':row', $row);
                    $stmt->execute();
                    echo "<h3>Row deleted successfully</h3>";

                    // re-enable foreign key checks
                    $conn->exec("SET FOREIGN_KEY_CHECKS = 1;");

                    // redirect to delete.html
                    header("Location: ../delete.html");
                    exit();
                }

                
               

            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            // Close the connection
            $conn = null;

        ?>
    </main>