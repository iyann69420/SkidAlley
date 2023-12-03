<?php
// Include your database connection here
include ('./config/constants.php');
if (!isset($_SESSION['userLoggedIn'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['product_id']) && isset($_POST['color']) && isset($_POST['size'])) {
    $product_id = $_POST['product_id'];
$color = $_POST['color'];
$size = $_POST['size'];

    // Query to fetch stock quantity based on color and size
    $sql = "SELECT sl.quantity
    FROM stock_list sl
    INNER JOIN product_colors_sizes pcs ON sl.product_colors_sizes_id = pcs.id
    WHERE sl.product_id = $product_id AND pcs.color = '$color' AND pcs.size = '$size'
    ";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $stock_quantity = $row['quantity'];
            echo $stock_quantity;
        } else {
            echo 'Stock not available for the selected color and size.';
        }
    } else {
        echo 'Error fetching stock quantity: ' . mysqli_error($conn);
    }
} else {
    echo 'Select Size.';
}
?>
