<?php
 include('partials/menu.php');

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the product_id is set in the POST data
    if (isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];

        // Get the start_time and end_time of the new discount being added
        $query = "SELECT start_time, end_time FROM discounts WHERE product_id = ? AND end_time > NOW()";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $existingStartTime = strtotime($row['start_time']);
                $existingEndTime = strtotime($row['end_time']);

                // Get the start_time and end_time from the form submission
                $newStartTime = strtotime($_POST['start_time']);
                $newEndTime = strtotime($_POST['end_time']);

                // Check for overlapping time periods
                if (($newStartTime >= $existingStartTime && $newStartTime <= $existingEndTime) ||
                    ($newEndTime >= $existingStartTime && $newEndTime <= $existingEndTime) ||
                    ($existingStartTime >= $newStartTime && $existingStartTime <= $newEndTime) ||
                    ($existingEndTime >= $newStartTime && $existingEndTime <= $newEndTime)) {
                    // Overlapping time periods, cannot add a new discount
                    echo 'exists';
                    exit;
                }
            }

            // No overlapping time periods, can proceed to add the new discount
            echo 'not_exists';
        } else {
            // Error in the query
            echo 'error';
        }
    } else {
        // Product ID not provided in the POST data
        echo 'invalid_request';
    }
} else {
    // Invalid request method
    echo 'invalid_request_method';
}

// Close the database connection if necessary
$conn->close();
?>
