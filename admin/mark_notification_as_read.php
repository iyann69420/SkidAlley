<?php
include('../config/constants.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['notification_id'])) {
    // Check if the notification_id has been sent
    if (isset($_POST['notification_id'])) {
        $notificationId = $_POST['notification_id'];

        // Update the is_read field in the database
        $updateSql = "UPDATE admin_notifications SET is_read = 1 WHERE id = $notificationId";
        if (mysqli_query($conn, $updateSql)) {
            echo "Notification marked as read successfully";
        } else {
            echo "Error updating notification: " . mysqli_error($conn);
        }
    } else {
        echo "Notification ID not provided";
    }
} else {
    echo "Invalid request";
}
?>
