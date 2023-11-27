<?php include ('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php
        $id = $_GET['id'];

        $sql = "SELECT * FROM admin WHERE id = $id";

        $res = mysqli_query($conn, $sql);

        if ($res == true) {
            $count = mysqli_num_rows($res);
            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);

                $full_name = $row['fullname'];
                $username = $row['username'];
                $user_role = $row['userrole']; // Fetching current user role
            } else {
                header('location:' . SITEURL . 'admin/admin.php');
            }
        }

        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td>User Role: </td>
                    <td>
                        <input type="radio" name="user_role" value="1" <?php if ($user_role == 1) echo 'checked'; ?>> Admin
                        <input type="radio" name="user_role" value="0" <?php if ($user_role == 0) echo 'checked'; ?>> Staff
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $user_role = $_POST['user_role']; // Fetching the updated user role

    $sql = "UPDATE admin SET
            fullname = '$full_name',
            username = '$username',
            userrole = '$user_role' 
            WHERE id ='$id'
        ";

    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        $_SESSION['update'] = "<div class ='success'>Admin Updated Successfully.</div>";
        header('location:' . SITEURL . 'admin/admin.php');
    } else {
        $_SESSION['update'] = "<div class ='error'>Failed to Update Admin.</div>";
        header('location:' . SITEURL . 'admin/admin.php');
    }
}
?>

<?php include ('partials/footer.php'); ?>
