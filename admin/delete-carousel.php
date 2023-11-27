<?php
include('../config/constants.php');

$id = $_GET['id'];


$sql_select_image = "SELECT images FROM content_management_carousel WHERE id=$id";
$result_select_image = mysqli_query($conn, $sql_select_image);

if ($result_select_image) {
    $row = mysqli_fetch_assoc($result_select_image);
    $current_image = $row['images'];

   
    $sql_delete_image = "DELETE FROM content_management_carousel WHERE id=$id";
    $result_delete_image = mysqli_query($conn, $sql_delete_image);

    if ($result_delete_image) {
     
        $image_path = "../images/carousel/" . $current_image;
        if (file_exists($image_path)) {
            unlink($image_path); // Delete the image file
        }
        
       
        $_SESSION['delete'] = "<div class='success'>Image Deleted Successfully</div>";
    } else {
        
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Image</div>";
    }
} else {
   
    $_SESSION['delete'] = "<div class='error'>Failed to Fetch Image Information</div>";
}

header('location:' . SITEURL . 'admin/carousel.php');
?>
