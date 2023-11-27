<?php include ('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        ?>
        <br /><br /><br />

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>

                <tr>
                    <td>User Name: </td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Username">
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Enter Password">
                    </td>
                </tr>

                <tr>
                    <td>User Role: </td>
                    <td>
                        <input type="radio" name="user_role" value="1" checked> Admin
                        <input type="radio" name="user_role" value="0"> Staff
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>


            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php') ?>

<?php
// Process the value from Form and save it to the database
// Check Whether the submit button is clicked or not

if (isset($_POST['submit'])) {
    // Button Clicked
    // Get data from Form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Password Encryption with MD5
    $user_role = $_POST['user_role'];

    // SQL query to save the data into the database
    $sql = "INSERT INTO admin (fullname, username, password, userrole) VALUES ('$full_name', '$username', '$password', '$user_role')";

    // Executing Query and saving data into the database
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    // Check whether the (query is executed) data is inserted or not and display appropriate message
    if ($res == true) {
        $_SESSION['add'] = "<div class='success'>Admin Added Successfully </div>";
        header("location:" . SITEURL . 'admin/admin.php');
    } else {
        $_SESSION['add'] = "<div class='error'>Failed to Add Admin </div>";
        header("location:" . SITEURL . 'admin/add-admin.php');
    }
}
?>
