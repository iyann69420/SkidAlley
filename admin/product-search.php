<?php include('../config/constants.php'); ?>

<?php

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$filterCategory = isset($_GET['filter_category']) ? mysqli_real_escape_string($conn, $_GET['filter_category']) : '';

// Check if filter_category is not empty to include it in the SQL query
$categoryCondition = ($filterCategory !== '') ? "AND category_id = '$filterCategory'" : '';

$sql = "SELECT * FROM product_list WHERE 
        (name LIKE '%$search%' OR models LIKE '%$search%' OR description LIKE '%$search%') 
        $categoryCondition";

$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);
$sn = 1;

if ($count > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        // Output the rows as HTML, similar to your existing code
        // ...
    }
} else {
    echo "<tr><td colspan='9' class='error'> No matching products found. </td></tr>";
}

?>
