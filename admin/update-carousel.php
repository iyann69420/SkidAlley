<?php
include('partials/menu.php');

$id = $_GET['id'];

if (!isset($id)) {
    header('location: ' . SITEURL . 'admin/carousel.php');
    exit();
}

if (isset($_POST['submit'])) {
    $current_image = $_POST['current_image'];

    // Check whether upload button is clicked or not
    if (isset($_FILES['image']['name'])) {
        // Upload button clicked
        // Check whether the file is available or not
        if ($_FILES['image']['name'] != "") {
            // Remove the current image if it exists
            if ($current_image != "") {
                $remove_path = "../images/carousel/" . $current_image;
                if (file_exists($remove_path)) {
                    unlink($remove_path);
                }
            }

            // Upload the new image
            $image_name = $_FILES['image']['name'];
            $ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $image_name = "category-" . uniqid() . '.' . $ext; // New image name
            $src_path = $_FILES['image']['tmp_name'];
            $dest_path = "../images/carousel/" . $image_name;

            $upload = move_uploaded_file($src_path, $dest_path);

            if (!$upload) {
                $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image.</div>";
                header('location: ' . SITEURL . 'admin/carousel.php');
                exit();
            }
        } else {
            $image_name = $current_image;
        }
    } else {
        $image_name = $current_image;
    }

    // Update the database with the new image name
    $sql3 = "UPDATE content_management_carousel SET images = '$image_name' WHERE id = $id";
    $res3 = mysqli_query($conn, $sql3);

    if ($res3) {
        $_SESSION['update'] = "<div class='success'>Image Updated Successfully.</div>";
        header('location: ' . SITEURL . 'admin/carousel.php');
        exit();
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to Update Image.</div>";
        header('location: ' . SITEURL . 'admin/carousel.php');
        exit();
    }
}

// Fetch the current image
$sql2 = "SELECT * FROM content_management_carousel WHERE id = $id";
$res2 = mysqli_query($conn, $sql2);

if ($res2) {
    $row2 = mysqli_fetch_assoc($res2);
    $current_image = $row2['images'];
} else {
    header('location: ' . SITEURL . 'admin/carousel.php');
    exit();
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Image</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Current Image</td>
                    <td>
                        <?php
                        if ($current_image == "") {
                            echo "<div class='error'>Image not Available.</div>";
                        } else {
                        ?>
                            <img src="<?php echo SITEURL; ?>images/carousel/<?php echo $current_image; ?>" width="200px">
                        <?php
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Image" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>
