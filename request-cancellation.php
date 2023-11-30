<?php
include('config/constants.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order_id']) && isset($_POST['order_products_id']) && isset($_POST['reason'])) {
        $order_id = $_POST['order_id'];
        $order_products_id = $_POST['order_products_id'];
        $reason = $_POST['reason'];

        $insertCancellationQuery = "INSERT INTO admin_notifications (order_id, order_products_id, reason, is_approved, is_read) VALUES (?, ?, ?, 0, 0)";

        $stmt = $conn->prepare($insertCancellationQuery);
        $stmt->bind_param("iss", $order_id, $order_products_id, $reason);

        if ($stmt->execute()) {
            // Redirect to orderstatus.php with a success message
            header("Location: orderstatus.php?success=Cancellation+request+submitted+successfully");
        } else {
            // Redirect to orderstatus.php with an error message
            header("Location: orderstatus.php?error=Failed+to+submit+cancellation+request.+Please+try+again+later");
            error_log($stmt->error); // Log the SQL error to the error log
        }
        $stmt->close();
    } else {
        // Redirect to orderstatus.php with an error message
        header("Location: orderstatus.php?error=Invalid+request.+Please+try+again");
    }
}
?>
