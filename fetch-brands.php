<?php
include ('./config/constants.php');

if (isset($_GET['categoryId'])) {
    // Sanitize the input to prevent SQL injection
    $categoryId = mysqli_real_escape_string($conn, $_GET['categoryId']);

    // Query to fetch brands based on the provided category ID
    $sql = "SELECT b.id, b.name FROM brand_list b
            JOIN category_brands cb ON b.id = cb.brand_id
            WHERE cb.category_id = '$categoryId'";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        $output = '';
        // Generate the options for the brand dropdown
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
            }
        } else {
            $output .= '<option value="">No Brands Found</option>';
        }
        // Return the generated options
        echo $output;
    } else {
        // Handle the case where the query fails
        echo "Error in fetching brands: " . mysqli_error($conn);
    }
} else {
    // Handle the case where the category ID is not set
    echo "Error: Category ID not set.";
}
?>
