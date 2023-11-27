<?php
// Include your necessary files and establish a database connection
include('config/constants.php');

// Check if notification_id is set in the POST request
if(isset($_POST['notification_id'])){
    $notificationId = $_POST['notification_id'];

    // Create SQL query to delete notification
    $sql = "DELETE FROM notifications WHERE notification_id=$notificationId";

    // Execute query
    $res = mysqli_query($conn, $sql);

    // Check whether the query is executed successfully or not
    if($res){
        header('location:'.SITEURL.'notifications.php');
    } else {
        // Handle SQL errors
        echo "Failed to Delete: " . mysqli_error($conn);
    }
} else {
    // Handle if notification_id is not set
    echo "Notification ID not provided.";
}
?>
