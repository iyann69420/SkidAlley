<?php
    // Check the user is logged in or not
    // Access Control
    if(!isset($_SESSION['user']))
    {
        $_SESSION['no-login-message'] = "<div class='error text-center'>Login to access Admin Panel</div>";
        header('location: '.SITEURL.'admin/login.php');
    }

    // Fetch the logged-in username from the session
    $username = $_SESSION['user']; // Assuming you have stored the username in the session

    

    // Fetch the user's role from the database
    $sql = "SELECT userrole FROM admin WHERE username = '$username'";
    $result = $conn->query($sql);

    // Check if the query was successful and if a row was returned
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userrole = $row['userrole'];

        // Set the user role in the session
        $_SESSION['userrole'] = $userrole;

        // Set access permissions based on user role
        if ($userrole == 0) {
            $contentManagement = false;
            $fileManagement = true;
            $orders = true;
            $admin = false;
        } elseif ($userrole == 1) {
            $contentManagement = true;
            $fileManagement = true;
            $orders = true;
            $admin = true;
        }
    } else {
        // Handle the case when the query fails or no row is returned
        // You might want to set default permissions or handle the error differently
        // For example, you might set all permissions to false
        $contentManagement = false;
        $fileManagement = false;
        $orders = false;
        $admin = false;
    }

   
?>
