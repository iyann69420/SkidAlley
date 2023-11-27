<?php


include ('./config/constants.php'); // Include the constants file

if (isset($_SESSION['otp'])) {
    $otp = $_SESSION['otp']; // Fetch the OTP from the session

    if (!isset($_SESSION['username'])) {
        header("Location: login.php"); // Redirect to the login page
        exit(); // Stop executing the code further
    }
    

    if (isset($_POST['submit'])) {
        // Access the entered OTP from the form
        $user_otp = $_POST['otp']; 

        if ($user_otp == $otp) {
            // OTP is correct
            // Get data from session variables
            $username = $_SESSION['username'];
            $fullname = $_SESSION['fullname'];
            $contact = $_SESSION['contact'];
            $address = $_SESSION['address'];
            $email = $_SESSION['email'];
            $password = $_SESSION['password'];

            // Check connection
            $sql = "INSERT INTO client_list (fullname, username, contact, address, email, password) VALUES ('$fullname', '$username', '$contact', '$address', '$email', '$password')";

            // Execute the query and save data into the database
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            // Check whether the query is executed, and display the appropriate message
            if ($res) {
                $_SESSION['add'] = "<div>Register Successfully</div>";
                header("location:" . SITEURL . 'index.php');
            } else {
                $_SESSION['add'] = "<div>Failed to Register</div>";
                header("location:" . SITEURL . 'index.php');
            }
        } else {
            echo "Invalid OTP. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
            flex-direction: column;
            font-family: Arial, sans-serif;
        }
        h2 {
            font-size: 32px;
            margin-bottom: 20px;
            font-family: 'Arial Black', sans-serif;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input[type="text"] {
            width: 200px;
            height: 40px;
            text-align: center;
            margin: 10px 0;
            font-size: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: black;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background-color: orange;
        }
    </style>
</head>
<body>
    
    <h2>Verify OTP</h2>
    <form action="" method="POST">
        <input type="text" name="otp" placeholder="Enter OTP" required>
        <input type="submit" name="submit" value="Verify">
    </form>
</body>
</html>
