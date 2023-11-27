<?php
include('../config/constants.php');

$id = $_GET['id'];

// Delete related reviews first
$deleteReviewsSql = "DELETE FROM reviews WHERE order_id=$id";
$resReviews = mysqli_query($conn, $deleteReviewsSql);

if (!$resReviews) {
    $_SESSION['delete'] = "<div class='error'>Failed to delete reviews</div>";
    header('location:' . SITEURL . 'admin/orders.php');
    exit(); // Exit script to prevent further execution
}

// Now, delete the order
$deleteOrderSql = "DELETE FROM order_list WHERE id=$id";
$resOrder = mysqli_query($conn, $deleteOrderSql);

// Check whether the query is executed successfully or not
if ($resOrder) {
    $_SESSION['delete'] = "<div class='success'>Deleted Successfully</div>";
    header('location:' . SITEURL . 'admin/orders.php');
} else {
    $_SESSION['delete'] = "<div class='error'>Failed to delete order</div>";
    header('location:' . SITEURL . 'admin/orders.php');
}

?>
