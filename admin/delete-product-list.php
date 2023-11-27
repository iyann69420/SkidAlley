<?php
include('../config/constants.php');

if (isset($_GET['id']) && isset($_GET['image_name'])) {
    $id = $_GET['id'];
    $image_name = $_GET['image_name']; // Corrected variable name

    if ($image_name != "") {
        $path = "../images/bike/" . $image_name; 

        $remove = unlink($path); // Added $ before path

        if ($remove == false) {
            $_SESSION['upload'] = "<div class='error'> Failed to Remove Image File. </div>";
            header('location: ' . SITEURL . 'admin/product-list.php');
            die();
        }
    }
    $sql = "DELETE FROM product_list WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    if ($res == true)
     {
        $_SESSION['delete'] = "<div class='success'>Product Deleted Successfully</div>";

        header('location:' . SITEURL . 'admin/product-list.php');
    } 
    else 
    {
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Product</div>";

        header('location:' . SITEURL . 'admin/product-list.php');
    }
} 
else 
{
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";

    header('location:' . SITEURL . 'admin/product-list.php');
}
?>
