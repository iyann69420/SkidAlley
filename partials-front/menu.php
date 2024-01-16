<?php include('config/constants.php'); ?>
<!DOCTYPE html>
<html lang="en">
    
<?php
if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] === true) {
    // Assuming the user ID is stored in $_SESSION['client_id']
    $userId = $_SESSION['client_id'];
} else {
    // Set $userId to a default value or handle the case when the user is not logged in
    $userId = null; // For example, setting it to null here
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Skid Alley Bike Shop </title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<style>
    .cart-link {
        position: relative;
        display: inline-block;
    }

    .cart-count {
        position: absolute;
        top: -12px;
        right: -13px;
        background-color: red;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        text-align: center;
        line-height: 20px;
        font-size: 14px;
    }

    .notifications {
        position: relative;
        display: inline-block;
    }

    .notification-count {
        position: absolute;
        top: -10px;
        right: -10px;
        background-color: red;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        text-align: center;
        line-height: 20px;
        font-size: 14px;
    }
</style>

<body>
    <!-- HEADER -->
    <div class="header">
        <?php
        $sql = "SELECT * FROM content_management_logo";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $logo = $row['logo'];

                ?>
                <div class="skidalley">
                <a href="<?php echo SITEURL; ?>index.php">  <?php
                            if ($logo == "") 
                            {
                                echo "<div class='error'>Image not Added.</div>";
                            } else {
                                ?>
                                <img src="<?php echo SITEURL; ?>images/logo/<?php echo $logo; ?>"
                                     width="100px">
                                <?php
                            }
                            ?>
                            </img> </a>
                <a href="<?php echo SITEURL; ?>index.php"> <h1 id="name"> Skid Alley Bike Shop </h1> </a>
                </div>
             <?php
            }

        }
        else
        {

            echo  "<td colspan='4'><div class='error'>No Logo Added.</div></td>";
        }
        
       


      ?>


        




        <div class="navbar">
            <a href="<?php echo SITEURL; ?>index.php"> <p> Home </p> </a>
            <a href="<?php echo SITEURL; ?>catalog.php"> <p> Catalog </p> </a>
            <!-- <a href="<?php echo SITEURL; ?>services.php"> <p> Service </p> </a> -->

            <a href="<?php echo SITEURL; ?>about.php"> <p> About </p> </a>
            <a href="<?php echo SITEURL; ?>contact.php"> <p> Contact </p> </a>
            <a href="<?php echo SITEURL; ?>cart.php" class="cart-link">
                <i class="fas fa-shopping-cart"></i>
                <?php
                if (isset($_SESSION['userLoggedIn'])) {
                    $productCount = getUniqueProductCount($userId);
                    if ($productCount > 0) {
                        echo '<span class="cart-count">' . $productCount . '</span>';
                    }
                }
                ?>


</a>

        </div>
        <div class="logsign">
            
        <?php
        // Check if the user is logged in (you need to implement this logic)
        if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] === true) {
            $username = $_SESSION['username'];
            $userId = $_SESSION['client_id'];
            
        ?>
            <div class="notifications">
            <a href="<?php echo SITEURL; ?>notifications.php">
                <p>Notifications</p>
                <?php
                if (isset($_SESSION['userLoggedIn'])) {
                    $notificationCount = getNotificationCount($userId);
                    if ($notificationCount > 0) {
                        echo '<span class="cart-count">' . $notificationCount . '</span>';
                    }
                }
                ?>
            </a>
        </div>
           
            <div class="user-container">
                <p id="username"><?php echo $username; ?></p>
                <div class="logout-dropdown">
                    <a href="<?php echo SITEURL; ?>orderstatus.php">My Order Status</a>
                    <a href="<?php echo SITEURL; ?>logout.php">Logout</a>
                </div>
            </div>
        <?php
        } 
        else 
        {
            
        ?>
            <a href="<?php echo SITEURL; ?>login.php"><p>Login</p></a>
            <p>|</p>
            <a href="<?php echo SITEURL; ?>signup.php"><p>Signup</p></a>
        <?php
        }
        ?>
    
        </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var username = document.getElementById("username");
        var logoutDropdown = document.querySelector(".logout-dropdown");

        username.addEventListener("click", function(e) {
            e.preventDefault();
            logoutDropdown.style.display = "block";
        });

        document.addEventListener("click", function(e) {
            if (!username.contains(e.target) && !logoutDropdown.contains(e.target)) {
                logoutDropdown.style.display = "none";
            }
        });
    });
</script>
</body>

<?php
function getUniqueProductCount($userId) {
    global $conn; // Use the database connection

    $uniqueProductCount = 0;

    // Example query: Count unique product IDs in the cart for the user
    $sql = "SELECT COUNT(DISTINCT CONCAT(product_id, '-', color, '-', size)) AS unique_product_count FROM cart_list WHERE client_id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $uniqueProductCount = $row['unique_product_count'];
    }

    return $uniqueProductCount;
}

function getNotificationCount($userId) {
    global $conn; // Use the database connection

    $notificationCount = 0;

    // Example query: Count unread notifications for the user
    $sql = "SELECT COUNT(*) AS notification_count FROM notifications WHERE user_id = $userId AND is_read = 0";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $notificationCount = $row['notification_count'];
    }

    return $notificationCount;
}
?>