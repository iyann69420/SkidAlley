<?php
// get-notification-count.php

include('../config/constants.php'); // Adjust the path if needed



if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch the notification count from the database
$query = "SELECT COUNT(*) as count FROM admin_notifications WHERE is_read = 0";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo $row['count'];
} else {
    echo "Error fetching notification count";
}

// Close the database connection
mysqli_close($conn);
?>
