<?php
include('config/constants.php');

$id = $_GET['id'];

// Create SQL query to delete cart item
$sql = "DELETE FROM cart_list WHERE id=$id";

// Execute the query
$res = mysqli_query($conn, $sql);

// Check whether the query is executed successfully or not
if ($res == true) {
    // Return a success response in JSON format
    echo json_encode(array('success' => true));
} else {
    // Return a failure response in JSON format
    echo json_encode(array('success' => false));
    
}
?>
