<?php 
include('../config/constants.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $notificationId = $_POST['notification_id'];

    // Perform the deletion in the database
    $deleteSql = "DELETE FROM admin_notifications WHERE id = $notificationId";
    $deleteResult = mysqli_query($conn, $deleteSql);

    if ($deleteResult) {
        echo 'Notification deleted successfully';
    } else {
        echo 'Error deleting notification: ' . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}

?>