<?php include ('./config/constants.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Login </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="loginpage">

    <?php
    
        if(isset($_SESSION['login']))
        {
        echo $_SESSION['login'];
        unset($_SESSION['login']);
        }

        if(isset($_SESSION['no-login-message']))
        {
        echo $_SESSION['no-login-message'];
        unset($_SESSION['no-login-message']);
        }
            
    ?>

        <form action="" method="POST" name="login">

        <a href="home.php"> <img style="width: 300px" src="images/logo.png"> </a>
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <div class="logsignbuttons">
           <input type="submit" name="submit" value="Login" name="login" >
            <a href="signup.php" > <p> Signup </p> </a>
        </div>


        </form>
        
    </div>
    <div class="footer sticky-footer">
        <p> 2023 Skid Alley Bike Shop. All rights reserved. </p>
    </div>  
</body>
</html>

<?php


   
   if(isset($_POST['submit']))
   {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM client_list WHERE username='$username' AND password='$password'";

    $res = mysqli_query($conn,$sql);

    $count = mysqli_num_rows($res);

    if($count==1)
    {
 
       $_SESSION['userLoggedIn'] = true; // Set the user's login status
       $_SESSION['username'] = $username;

       $user_data = mysqli_fetch_assoc($res);
       $_SESSION['client_id'] = $user_data['id'];
       header('location:'.SITEURL.'home.php');
    }
    else
    {
       $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match</div>";
       header('location:'.SITEURL.'login.php');

    }


   }

?>