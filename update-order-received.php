<?php
include('partials-front/menu.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Perform the update in the database
    $updateQuery = "UPDATE order_list SET order_receive = 1 WHERE id = $order_id";

    if (mysqli_query($conn, $updateQuery)) {
        // Update successful

        // Add notification to admin_notifications
        $notificationQuery = "INSERT INTO admin_notifications (order_id, notification_type, is_approved, is_read) VALUES ($order_id, 'Order Received', 2, 0)";
        mysqli_query($conn, $notificationQuery);

        echo "Order Received successfully updated.";
    } else {
        // Update failed
        echo "Error updating order status: " . mysqli_error($conn);
    }
} else {
    // Invalid request
    echo "Invalid request.";
}

// Close the database connection
mysqli_close($conn);
?>
