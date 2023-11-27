<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Logo</h1>
        <br><br>

        <?php
        // Initialize $id with a default value
        $id = 0;

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Rest of your code
        } else {
            header('location: ' . SITEURL . 'admin/logo.php');
            exit();
        }

        if (isset($_POST['submit'])) {
            $current_logo = $_POST['current_logo'];

            // Check whether upload button is clicked or not
            if (isset($_FILES['image']['name'])) {
                // Upload button clicked
                $image_name = $_FILES['image']['name']; // New image name

                // Check whether the file is available or not
                if ($image_name != "") {
                    // Image name available
                    // Rename the image
                    $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                    $image_name = "logo-" . uniqid() . '.' . $ext; // This will be the renamed image

                    // Get the source path and destination path
                    $src_path = $_FILES['image']['tmp_name'];
                    $dest_path = "../images/logo/" . $image_name;

                    // Upload the image
                    $upload = move_uploaded_file($src_path, $dest_path);

                    // Check whether the image is uploaded or not
                    if (!$upload) {
                        // Failed to upload
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload New Logo.</div>";
                        header('location: ' . SITEURL . 'admin/logo.php');
                        exit();
                    }

                    // Remove the current image if available
                    if ($current_logo != "") {
                        // Remove the image
                        $remove_path = "../images/logo/" . $current_logo;

                        $remove = unlink($remove_path);

                        // Check whether it's removed or not
                        if (!$remove) {
                            // Failed to remove
                            $_SESSION['remove-failed'] = "<div class='error'>Failed to Remove Current Logo.</div>";
                            header('location: ' . SITEURL . 'admin/logo.php');
                            exit();
                        }
                    }
                } else {
                    $image_name = $current_logo;
                }
            } else {
                $image_name = $current_logo;
            }

            $sql3 = "UPDATE content_management_logo SET logo = '$image_name' WHERE id = $id";
            $res3 = mysqli_query($conn, $sql3);

            if ($res3) {
                $_SESSION['update'] = "<div class='success'>Logo Updated Successfully.</div>";
                header('location: ' . SITEURL . 'admin/logo.php');
                exit();
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to Update Logo.</div>";
                header('location: ' . SITEURL . 'admin/logo.php');
                exit();
            }
        }
        ?>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $sql2 = "SELECT * FROM content_management_logo WHERE id = $id";
            $res2 = mysqli_query($conn, $sql2);

            if ($res2) {
                $row2 = mysqli_fetch_assoc($res2);
                $current_logo = $row2['logo'];
            } else {
                // Handle the error or redirect as needed
            }
        } else {
            header('location: ' . SITEURL . 'admin/logo.php');
            exit(); // Add exit to stop further execution
        }
        ?>

        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Current Logo</td>
                    <td>
                        <?php
                        if ($current_logo == "") {
                            echo "<div class='error'>Logo not Available.</div>";
                        } else {
                        ?>
                            <img src="<?php echo SITEURL; ?>images/logo/<?php echo $current_logo; ?>" width="200px">
                        <?php
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Logo</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_logo" value="<?php echo $current_logo; ?>">
                        <input type="submit" name="submit" value="Update Logo" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>
