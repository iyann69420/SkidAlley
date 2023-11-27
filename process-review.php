<?php
include('./config/constants.php');

// Function to validate and sanitize input
function validateInput($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (isset($_SESSION['client_id'])) {
        // The user is logged in, get the client_id from the session
        $client_id = $_SESSION['client_id'];

        // Validate and sanitize input data
        $order_id = isset($_POST['order_id']) ? validateInput($_POST['order_id']) : '';
        $stars = isset($_POST['stars']) ? intval($_POST['stars']) : 0;
        $review_text = isset($_POST['review']) ? validateInput($_POST['review']) : '';

        // Check if the required fields are not empty
        if (!empty($order_id) && !empty($stars) && !empty($review_text)) {
            // Handle the uploaded image
            $image_name = ""; // Initialize $image_name variable

            if (isset($_FILES['image'])) {
                $uploadedImage = $_FILES['image'];
                $uploadPath = __DIR__ . '../images/reviews/';
                $ext = pathinfo($uploadedImage['name'], PATHINFO_EXTENSION);
                $image_name = "Review-" . rand(0000, 9999) . "." . $ext;
                $dst = $uploadPath . $image_name;

                // Move the uploaded file to the upload directory
                $uploadSuccess = move_uploaded_file($uploadedImage['tmp_name'], $dst);

                if (!$uploadSuccess) {
                    echo "<p>Failed to upload the image.</p>";
                    exit();
                }
            }

            // Insert the review data into the database
            $insertQuery = "INSERT INTO reviews (order_id, client_id, image_path, stars, review_text) VALUES ('$order_id', '$client_id', '$image_name', '$stars', '$review_text')";

            $insertResult = mysqli_query($conn, $insertQuery);

            if ($insertResult) {
                // Set a session variable to indicate that the review was submitted successfully
                $_SESSION['reviewSubmitted'] = true;
                header('location:' . SITEURL . 'orderstatus.php'); 
                exit();
            } else {
                echo "<p>Error submitting the review: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p>Missing required fields.</p>";
        }
    } else {
        echo "<p>User not logged in.</p>";
    }
} else {
    echo "<p>Invalid request method.</p>";
}

// Close the database connection
mysqli_close($conn);
?>
