<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('./config/constants.php');

// Establish a database connection using constants.php

// Your database connection code here

// Select discounts with end time passed
$currentDateTime = date('Y-m-d H:i:s');
$sql = "SELECT * FROM `discounts` WHERE `end_time` <= '$currentDateTime'";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Fetch the data and delete the rows
    while ($row = mysqli_fetch_assoc($result)) {
        $discountId = $row['id'];

        // Delete the row
        $deleteSql = "DELETE FROM `discounts` WHERE `id` = $discountId";
        $deleteResult = mysqli_query($conn, $deleteSql);

        if ($deleteResult) {
            echo "Discount with ID $discountId deleted successfully.<br>";
        } else {
            // Handle delete error
            echo "Error deleting discount with ID $discountId: " . mysqli_error($conn) . "<br>";
        }
    }

    // Free the result set
    mysqli_free_result($result);
} else {
    // Handle query error
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
