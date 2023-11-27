<?php
// Assuming you have already established a database connection
include ('./config/constants.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notification_id'])) {
    $notificationId = $_POST['notification_id'];

    // Update the is_read field in the database
    $updateSql = "UPDATE notifications SET is_read = 1 WHERE notification_id = $notificationId";
    if (mysqli_query($conn, $updateSql)) {
        echo "Notification updated successfully.";
    } else {
        echo "Error updating notification: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
