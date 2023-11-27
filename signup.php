<?php include ('./config/constants.php');?>
<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require 'vendor/autoload.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<style>
    /* Add some styling to position the eye icon */
    .password-container {
        position: relative;
        display: inline-block;
    }

    .password-input {
        width: 400px !important;
        padding-right: 30px; /* Adjust this value to create space for the eye icon */
    }

    .password-icon {
        position: absolute;
        right: 5px; /* Adjust this value to your preference */
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>

<script>
    function togglePassword(fieldId, iconId) {
        var passwordInput = document.getElementById(fieldId);
        var icon = document.getElementById(iconId);
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        }
    }
</script>




<body>
    <div class="signuppage">
        <title> Signup </title>
        <link rel="stylesheet" href="style.css">

        <?php

        if(isset($_SESSION['password_mismatch']))
        {
            echo $_SESSION['password_mismatch'];
            unset($_SESSION['password_mismatch']);
        }
        if(isset($_SESSION['empty']))
        {
            echo $_SESSION['empty'];
            unset($_SESSION['empty']);
        }
        if(isset($_SESSION['blank']))
        {
            echo $_SESSION['blank'];
            unset($_SESSION['blank']);
        }


        ?>
        
      
 

        <form action="" method="POST" name="signup">
        <br>
        <a href="index.php"> <img style="width: 100px" src="images/logo.png"> </a>
        <h1> Sign Up </h1>
        <br>
        <input type="text" name="username" placeholder="Username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
        <input type="text" name="fullname" placeholder="Full name" value="<?php echo isset($_POST['fullname']) ? $_POST['fullname'] : ''; ?>">
        <input type="number" name="contact" placeholder="Contact" value="<?php echo isset($_POST['contact']) ? $_POST['contact'] : ''; ?>">
        <input type="text" name="address" placeholder="Home address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>">
        <input type="email" name="email" placeholder="E-mail address" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">

        <div class="password-container">
    <input type="password" name="password" id="password" class="password-input" placeholder="Password">
    <span class="password-icon" onclick="togglePassword('password', 'togglePasswordIcon')">
        <i id="togglePasswordIcon" class="fa fa-eye-slash" aria-hidden="true"></i>
    </span>
</div>

<!-- Confirm Password input field with the eye icon inside the text box -->
<div class="password-container">
    <input type="password" name="confirm_password" id="confirm_password" class="password-input" placeholder="Confirm Password">
    <span class="password-icon" onclick="togglePassword('confirm_password', 'toggleConfirmPasswordIcon')">
        <i id="toggleConfirmPasswordIcon" class="fa fa-eye-slash" aria-hidden="true"></i>
    </span>
</div>
        
        <input type="submit" name="submit" value="Submit" name="signup" > 
        </form>
    </div>

</html>

<?php
if(isset($_POST['submit']))
{
    //Button Clicked
    //echo "Button Clicked";
    $username = $_POST['username'];
    $check_username = "SELECT * FROM client_list WHERE username = '$username'";
    $check_result = mysqli_query($conn, $check_username);
    if(mysqli_num_rows($check_result) > 0) {
        // Username already exists
        $_SESSION['blank'] = "Username already exists. Please choose a different username.";
        header("location: signup.php");
        exit;
    }else{
    //get data from Form
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $confirm_password = md5($_POST['confirm_password']);
    
    $password = md5($_POST['password']); //Password Encrption with MD5
   
    if(empty($_POST['username']) || empty($_POST['fullname']) || empty($_POST['contact']) || empty($_POST['address']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
       
        $_SESSION['empty'] = "Please fill in all the fields.";
       
        header("location: signup.php");
        exit;
    }
 
    // Check if the password matches the confirm password
    if ($password !== $confirm_password) {
        $_SESSION['password_mismatch'] = "Password did not match";
        header("location: signup.php");
        exit;
    }


    

    $_SESSION['username'] = $username;
    $_SESSION['fullname'] = $fullname;
    $_SESSION['contact'] = $contact;
    $_SESSION['address'] = $address;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;

    // Redirect to the OTP verification page
    header("location: verify_otp.php");
 
    $mail = new PHPMailer(true);
    // Generate OTP
    $otp = mt_rand(100000, 999999); // Generate a 6-digit random OTP

    // Use PHPMailer to send the OTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Set your SMTP host
    $mail->SMTPAuth = true;
    $mail->Username = 'iansalgado567@gmail.com'; // Set your SMTP username
    $mail->Password = 'obid wjcj ztjv nhbm'; // Set your SMTP password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('your_email@example.com', 'Skid Alley');
    $mail->addAddress($email, $fullname); // Add recipient's email
    $mail->isHTML(true);

    $mail->Subject = 'Your OTP for Signup';
    $mailContent = '<!DOCTYPE html>
                    <html>
                    <head>
                        <title>Your OTP for Signup</title>
                    </head>
                    <body>
                        <div style="font-family: Arial, sans-serif; padding: 20px;">
                            <h2>Hello, ' . $fullname . '!</h2>
                            <p>Your OTP for signup is: <strong>' . $otp . '</strong></p>
                            <p>Please use this OTP to verify your account.</p>
                            <br/>
                            <p>Regards,</p>
                            <p>Skid Alley Team</p>
                        </div>
                    </body>
                    </html>';

    $mail->Body = $mailContent;


    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        // Save the OTP in the session or the database to verify it later
        $_SESSION['otp'] = $otp;

        // Redirect to the OTP verification page
        header("location: verify_otp.php");
    }
    
}
    

}






?>
<?php include('partials-front/footer.php'); ?>