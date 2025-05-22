<?php
include 'connectToDB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="full_database_export.csv"');

    $output = fopen("php://output", "w");

    // Get all table names
    $tables_result = $conn->query("SHOW TABLES");

    while ($table_row = $tables_result->fetch(PDO::FETCH_NUM)) {
        $table_name = $table_row[0];

        // Write table name
        fputcsv($output, []); // Blank line
        fputcsv($output, ["Table: $table_name"]);

        // Get column headers
        $columns_result = $conn->query("DESCRIBE `$table_name`");
        $headers = [];
        while ($column = $columns_result->fetch(PDO::FETCH_ASSOC)) {
            $headers[] = $column['Field'];
        }
        fputcsv($output, $headers);

        // Get all data
        $data_result = $conn->query("SELECT * FROM `$table_name`");
        while ($row = $data_result->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, array_values($row));
        }
    }

    fclose($output);
    exit;
}
?>
