<?php
 include ('../config/constants.php');
 
 if (isset($_GET['product'])) {
    $product = $_GET['product'];

    // Query the database to fetch colors and sizes for the selected product
    $sql = "SELECT id, color, size FROM product_colors_sizes WHERE product_id = $product";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        // Return JSON response
        echo json_encode(array("success" => true, "data" => $data));
    } else {
        // Handle database query error
        echo json_encode(array("success" => false, "message" => "Error fetching colors and sizes"));
    }
} else {
    // Handle missing 'product' parameter
    echo json_encode(array("success" => false, "message" => "Product parameter is missing"));
}
?>