<?php
include('../config/constants.php');

// Get the voucher_id from the URL
$id = $_GET['voucher_id'];

// Create SQL query to delete voucher
$sql = "DELETE FROM vouchers WHERE voucher_id=$id";

// Execute the query
$res = mysqli_query($conn, $sql);

// Check whether the query is executed successfully or not
if ($res == true) {
    $_SESSION['delete'] = "<div class='success'>Deleted Successfully</div>";
    header('location:' . SITEURL . 'admin/vouchers.php');
} else {
    $_SESSION['delete'] = "<div class='error'> Delete Supplier</div>";
    header('location:' . SITEURL . 'admin/vouchers.php');
}
?>
