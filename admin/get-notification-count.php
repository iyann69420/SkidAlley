<?php


include('../config/constants.php'); 

function getNotificationCount($conn) {
   
    $query = "SELECT COUNT(*) as count FROM admin_notifications WHERE is_read = 0";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    } else {
        return "Error fetching notification count";
    }
}

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$notificationCount = getNotificationCount($conn);

mysqli_close($conn);


echo $notificationCount;
?>
