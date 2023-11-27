<?php
include('../config/constants.php');

$id = $_GET['id'];

// First, retrieve the current logo file name from the database
$sql_select_logo = "SELECT logo FROM content_management_logo WHERE id=$id";
$result_select_logo = mysqli_query($conn, $sql_select_logo);

if ($result_select_logo) {
    $row = mysqli_fetch_assoc($result_select_logo);
    $current_logo = $row['logo'];

    // Delete the logo record from the database
    $sql_delete_logo = "DELETE FROM content_management_logo WHERE id=$id";
    $result_delete_logo = mysqli_query($conn, $sql_delete_logo);

    if ($result_delete_logo) {
        // Delete the logo image file from the folder
        $image_path = "../images/logo/" . $current_logo;
        if (file_exists($image_path)) {
            unlink($image_path); // Delete the image file
        }

        // Logo and image deleted successfully
        $_SESSION['delete'] = "<div class='success'>Logo Deleted Successfully</div>";
    } else {
        // Failed to delete the logo record
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Logo</div>";
    }
} else {
    // Failed to fetch the current logo from the database
    $_SESSION['delete'] = "<div class='error'>Failed to Fetch Logo Information</div>";
}

// Redirect back to the logo management page
header('location:' . SITEURL . 'admin/logo.php');
?>
