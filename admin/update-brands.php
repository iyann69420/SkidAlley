<?php include ('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Brand</h1>
        <br><br>

        <?php
        if (isset($_SESSION['error'])) 
        {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }?>

        <?php
        $id = $_GET['id'];

        $sql = "SELECT * FROM brand_list WHERE id = $id";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        if (isset($_GET['id'])) {
            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);
                $title = $row['name'];
                $status = $row['status'];
            } else {
                $_SESSION['no-brand-found'] = "<div class='error'> Brands not found</div>";
                header('location:' . SITEURL . 'admin/brands.php');
            }
        } else {
            header('location:' . SITEURL . 'admin/brands.php');
        }

        // Validation for empty category title
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $status = isset($_POST['status']) ? $_POST['status'] : 'No';

            // Validation for empty category title
            if (empty($title)) {
                $_SESSION['error'] = "<div class='error'>Please input a title.</div>";
                header('location:' . SITEURL . 'admin/update-brands.php?id=' . $id);
                exit(); // Add exit to stop further execution
            }

            // Check if the category title already exists
            $check_sql = "SELECT * FROM brand_list WHERE name = '$title' AND id != $id";
            $check_result = mysqli_query($conn, $check_sql);

            if (mysqli_num_rows($check_result) > 0) {
                // Category title already exists, show an error message
                $_SESSION['error'] = "<div class='error'>Brand Title already exists.</div>";
                header('location: ' . SITEURL . 'admin/update-brands.php?id=' . $id);
                exit(); // Add exit to stop further execution
            }

            $sql2 = "UPDATE brand_list SET
                    name = '$title',
                    status = '$status'
                    WHERE id=$id";

            $res2 = mysqli_query($conn, $sql2);

            if ($res2 == true) {
                $_SESSION['update'] = "<div class='success'>Brands Updated Successfully.</div>";
                header('location:' . SITEURL . 'admin/brands.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to Update Brands.</div>";
                header('location:' . SITEURL . 'admin/brands.php');
            }
        }
        ?>





       

        <br><br>

        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <table class="tbl-30">
                <tr>
                    <td>Brand Name: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status:</td>
                        <td>
                            <input <?php if ($status == 1) { echo "checked"; } ?> type="radio" name="status" value="1"> Active
                            <input <?php if ($status == 0) { echo "checked"; } ?> type="radio" name="status" value="0"> Inactive
                        </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

   
    </div>
</div>

<?php include ('partials/footer.php');?>
