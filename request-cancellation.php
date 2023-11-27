<?php
include('config/constants.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order_id']) && isset($_POST['reason'])) {
        $order_id = $_POST['order_id'];
        $order_products_id = $_POST['order_products_id'];
        $reason = $_POST['reason'];

        // Perform necessary validation and sanitization here
        // ...

        // Check if the order_id already exists in the admin_notifications table
        $checkOrderQuery = "SELECT * FROM admin_notifications WHERE order_id = ?";
        $stmtCheck = $conn->prepare($checkOrderQuery);
        $stmtCheck->bind_param("i", $order_id);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();

        if ($result->num_rows > 0) {
            // Redirect to orderstatus.php with an error message
            header("Location: orderstatus.php?error=A+cancellation+request+for+this+order+has+already+been+submitted");
        } else {
            // Insert the cancellation request into the admin_notifications table using prepared statements
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
        }
        $stmtCheck->close();
    } else {
        // Redirect to orderstatus.php with an error message
        header("Location: orderstatus.php?error=Invalid+request.+Please+try+again");
    }
}
?>
