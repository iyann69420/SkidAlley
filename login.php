<?php include('./config/constants.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/themes/default.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>
    <script>
        // Function to show Alertify error
        function showError(message) {
            alertify.error(message);
        }
    </script>
</head>
<body>
    <div class="login-container">
        <div class="loginpage">
            <?php
            if (isset($_SESSION['no-login-message'])) {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
            if (isset($_SESSION['login'])) {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            ?>
            <form action="" method="POST" name="login">
                <div class="loginimage">
                <a href="home.php"> <img style="width: 300px" src="images/logo.png"> </a>
                </div>
                
                <input type="text" name="username" placeholder="Username" <?php if(isset($_SESSION['login'])) echo "style='border: 1px solid red;'"; ?>>
                <input type="password" name="password" placeholder="Password" <?php if(isset($_SESSION['login'])) echo "style='border: 1px solid red;'"; ?>>
                <div class="logsignbuttons">
                    <input type="submit" name="submit" value="Login" name="login">
                </div>
                <div class="register-link-container">
                    <a href="signup.php" class="register-link">Don't have an account? Register here</a>
                </div>
            </form>
        </div>
        
    </div>
    
</body>
</html>

<?php include('partials-front/footer.php'); ?>
<?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // Check for blank or empty input
    if (empty($username) || empty($password)) {
        $_SESSION['login'] = "<div class='error text-center'>Username or Password cannot be blank</div>";
        // Call the JavaScript function to show the Alertify error
        echo "<script>showError('Username or Password cannot be blank');</script>";
    } else {
        $sql = "SELECT * FROM client_list WHERE username='$username' AND password='$password'";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            $_SESSION['userLoggedIn'] = true;
            $_SESSION['username'] = $username;

            $user_data = mysqli_fetch_assoc($res);
            $_SESSION['client_id'] = $user_data['id'];
            header('location:' . SITEURL . 'home.php');
            exit(); 
        } else {
            $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match</div>";
            // Call the JavaScript function to show the Alertify error
            echo "<script>showError('Username or Password did not match');</script>";
        }
    }
}
?>
