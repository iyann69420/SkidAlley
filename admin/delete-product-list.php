<?php
date_default_timezone_set('Asia/Manila');
// Include database connection and constants
include ('../config/constants.php');

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get current timestamp
$currentTimestamp = date("Y-m-d H:i:s");

// Construct the SQL query to select rows where end_time has passed
$selectSql = "SELECT * FROM discounts WHERE end_time < '$currentTimestamp'";


// Output the SQL query for debugging
echo "Debugging: $selectSql<br>";

// Execute the select query
$selectResult = $conn->query($selectSql);

// Check for errors and affected rows
if ($selectResult !== FALSE) {
    $affectedRows = $selectResult->num_rows;

    // Output the number of affected rows for debugging
    echo "Debugging: Affected rows: $affectedRows<br>";

    if ($affectedRows > 0) {
        // Construct the SQL query to delete rows where end_time has passed
        $deleteSql = "DELETE FROM discounts WHERE end_time < '$currentTimestamp'";

        // Output the SQL query for debugging
        echo "Debugging: $deleteSql<br>";

        // Execute the delete query
        $deleteResult = $conn->query($deleteSql);

        // Check for errors and affected rows
        if ($deleteResult !== FALSE) {
            $affectedRows = $conn->affected_rows;

            // Output the number of affected rows for debugging
            echo "Debugging: Affected rows: $affectedRows<br>";

            if ($affectedRows > 0) {
                echo "Rows deleted successfully. Affected rows: $affectedRows.<br>";
            } else {
                echo "No rows deleted. No rows matched the condition.<br>";
            }
        } else {
            // Output any error message for debugging
            echo "Debugging: MySQL error message: " . $conn->error . "<br>";
            echo "Error executing delete query: " . $conn->error;
        }
    } else {
        echo "No rows to delete. No rows matched the condition.<br>";
    }
} else {
    // Output any error message for debugging
    echo "Debugging: MySQL error message: " . $conn->error . "<br>";
    echo "Error executing select query: " . $conn->error;
}

// Close database connection
$conn->close();
?>
