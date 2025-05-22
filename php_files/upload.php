<?php
require_once 'connectToDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['csv_file']) && isset($_POST['table'])) {
        $file = $_FILES['csv_file']['tmp_name'];
        $table = $_POST['table'];

        if (($handle = fopen($file, 'r')) !== FALSE) {
            $headers = fgetcsv($handle, 1000, ",");
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $record = array_combine($headers, $data);

                $columns = implode(", ", array_keys($record));
                $values = implode("', '", array_map('addslashes', array_values($record)));
                $updates = implode(", ", array_map(function ($key) use ($record) {
                    return "$key='" . addslashes($record[$key]) . "'";
                }, array_keys($record)));

                $checkKey = array_keys($record)[0];
                $checkValue = $record[$checkKey];

                $sql_check = "SELECT COUNT(*) FROM $table WHERE $checkKey = '$checkValue'";
                $result = mysqli_query($conn, $sql_check);
                $exists = mysqli_fetch_row($result)[0];

                if ($exists > 0) {
                    $sql = "UPDATE $table SET $updates WHERE $checkKey = '$checkValue'";
                } else {
                    $sql = "INSERT INTO $table ($columns) VALUES ('$values')";
                }

                if (!mysqli_query($conn, $sql)) {
                    echo "Error: " . mysqli_error($conn);
                }
            }
            fclose($handle);
            echo "✅ Data import complete.";
        } else {
            echo "❌ Failed to open uploaded file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Database</title>
    <link rel="stylesheet" href="../stylesheets/homepage_stylesheet.css">
</head>
<body>
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

    <main>
        <section class="content">
            <h2>Import CSV Data</h2>
            <p>Select a table and upload a properly formatted CSV file.</p>

            <form method="POST" enctype="multipart/form-data">
                <label for="csv_file">Upload CSV File:</label><br>
                <input type="file" name="csv_file" id="csv_file" required><br><br>

                <label for="table">Select Table:</label><br>
                <select name="table" id="table">
                    <option value="Outbreak">Outbreak</option>
                    <option value="Patient">Patient</option>
                    <option value="Healthcare_Provider">Healthcare_Provider</option>
                </select><br><br>

                <input type="submit" value="Import Data">
            </form>
        </section>
    </main>

    <footer>
        <p>Applied Databases Group Project 2025</p>
    </footer>
</body>
</html>
