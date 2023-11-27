<?php include ('./config/constants.php');?>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartId = $_POST['cartId'];
    $newQuantity = $_POST['newQuantity'];

    // Perform the database update here (e.g., using prepared statements)
    $sql = "UPDATE cart_list SET quantity = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $newQuantity, $cartId);

    if ($stmt->execute()) {
        // Update successful
        $response = array('success' => true);
    } else {
        // Update failed
        $response = array('success' => false, 'message' => 'Failed to update quantity in the database.');
    }

    echo json_encode($response);
} else {
    // Invalid request method
    http_response_code(400);
}
?>
