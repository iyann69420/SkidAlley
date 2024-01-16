<?php include('partials/menu.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>

<style>
    .modal {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 50px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.9);
}

/* Style for the modal content */
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}

/* Style for the close button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}
</style>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br/>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        $userId = isset($_SESSION['client_id']) ? $_SESSION['client_id'] : null;

        $id = $_GET['id'];
        $sql = "SELECT ol.*, cl.fullname AS client_name FROM order_list ol
        INNER JOIN client_list cl ON ol.client_id = cl.id
        WHERE ol.id = $id";
        $res = mysqli_query($conn, $sql);

        if ($res == true) {
            $count = mysqli_num_rows($res);
            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);
                $client_id = $row['client_id'];
                $total_amount = $row['total_amount'];
                $deliveryAddress = $row['delivery_address'];
                $paymentMethod = $row['payment_method'];
                $status = $row['status'];
                $order_receive = $row['order_receive'];
                $message = $row['message'];
                $client_name = $row['client_name'];
                
            } else {
                header('location:' . SITEURL . 'admin/orders.php');
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Check if the approval status and Gcash receipt id are set
            if (isset($_POST['approval_status']) && isset($_POST['gcash_receipt_id'])) {
                // Get the approval status and Gcash receipt id from the form
                $approvalStatus = $_POST['approval_status'];
                $gcashReceiptId = $_POST['gcash_receipt_id'];

            if ($paymentMethod === 'Gcash' && $approvalStatus == 1 && !empty($gcashReceiptId)) {
                // Update the approved field in the gcash_receipts table
                $updateGcashReceiptSql = "UPDATE gcash_receipts SET approved = 1 WHERE id = $gcashReceiptId";
                $updateGcashReceiptResult = mysqli_query($conn, $updateGcashReceiptSql);

                if ($updateGcashReceiptResult) {
                    // Use Alertify for success message
                    echo '<script>alertify.success("Gcash receipt approved successfully and status updated.");</script>';
                } else {
                    // Use Alertify for error message
                    echo '<script>alertify.error("Error updating Gcash receipt status: ' . mysqli_error($conn) . '");</script>';
                }
            }
            elseif ($approvalStatus == 0) {
                // Disapproval logic here
            } else {
                // Handle other cases or provide appropriate feedback
            }
            // Additional logic for disapproval
            if ($approvalStatus == 0) {
                // Update the related foreign key in admin_notifications
                $updateNotificationsSql = "UPDATE admin_notifications SET gcash_receipts_id = NULL WHERE gcash_receipts_id = $gcashReceiptId";
                $updateNotificationsResult = mysqli_query($conn, $updateNotificationsSql);
            
                if ($updateNotificationsResult) {
                    // Now, you can safely delete the row from gcash_receipts
                    $deleteSql = "DELETE FROM gcash_receipts WHERE id = $gcashReceiptId";
                    $deleteResult = mysqli_query($conn, $deleteSql);
            
                    if ($deleteResult) {
                        echo 'Gcash receipt disapproved, related notifications updated, and row deleted successfully.';
                    } else {
                        echo 'Error deleting row from gcash_receipts: ' . mysqli_error($conn);
                    }
                    
                    // Add notification for disapproval
                    $notificationMessage = "Gcash receipt disapproved.";
                    $notificationType = "Gcash Disapproval";
            
                    // Insert the notification into the notifications table
                    $userId = isset($_SESSION['client_id']) ? $_SESSION['client_id'] : null;
                    $timestamp = date('Y-m-d H:i:s');
                    $status = "new";
                    $isRead = 0;
                    $promoId = 0; // Replace this with the actual promo ID if applicable
            
                    $insertNotificationSql = "INSERT INTO notifications (user_id, message, notification_type, timestamp, status, is_read, promo_id) 
                                              VALUES ($userId, '$notificationMessage', '$notificationType', '$timestamp', '$status', $isRead, $promoId)";
            
                    mysqli_query($conn, $insertNotificationSql);
                } else {
                    echo 'Error updating admin_notifications: ' . mysqli_error($conn);
                }
            } else {
                // Update the notifications table based on approval status
                $notificationMessage = $approvalStatus == 1
                    ? "Gcash receipt approved successfully."
                    : "Gcash receipt disapproved.";
                $notificationType = $approvalStatus == 1
                    ? "Gcash Approval"
                    : "Gcash Disapproval";
            
                // Insert the notification into the notifications table
                $userId = isset($_SESSION['client_id']) ? $_SESSION['client_id'] : null;
                $timestamp = date('Y-m-d H:i:s');
                $status = "new";
                $isRead = 0;
                $promoId = 0; // Replace this with the actual promo ID if applicable
            
                $insertNotificationSql = "INSERT INTO notifications (user_id, message, notification_type, timestamp, status, is_read, promo_id) 
                                          VALUES ($userId, '$notificationMessage', '$notificationType', '$timestamp', '$status', $isRead, $promoId)";
            
                mysqli_query($conn, $insertNotificationSql);
            }
            
                    // ... (your existing code)
            
                } else {
                
                }
            
            }
    
        ?>

        <br/><br/><br/>

        <form action="" method="POST" onsubmit="return validateStatusChange();">
            <table class="tbl-30">
                
                <tr>
                    <td>Client Name: </td>
                    <td><?php echo $client_name;?></td>
                </tr>

                <tr>
                    <td>Delivery Address: </td>
                    <td><?php echo $deliveryAddress; ?></td>
                </tr>

                <tr>
                    <td>Total Amount: </td>
                    <td>₱<?php echo number_format($total_amount); ?></td>
                </tr>

                <tr>
                    <td>Payment Method: </td>
                    <td><?php echo $paymentMethod; ?></td>
                </tr>


                
                <?php if ($paymentMethod == 'Gcash'): ?>
    <tr>
        <td>Gcash Receipt: </td>
        <td>
            <?php
            // Fetch Gcash receipt details
            $gcashReceiptId = $row['gcash_receipts_id'];

            if (!empty($gcashReceiptId)) {
                $gcashReceiptSql = "SELECT id, file_path, approved FROM gcash_receipts WHERE id = $gcashReceiptId";
                $gcashReceiptResult = mysqli_query($conn, $gcashReceiptSql);

                if ($gcashReceiptResult && mysqli_num_rows($gcashReceiptResult) > 0) {
                    $gcashReceiptRow = mysqli_fetch_assoc($gcashReceiptResult);
                    $gcashReceiptPath = SITEURL . $gcashReceiptRow['file_path'];
                    $gcashReceiptId = $gcashReceiptRow['id'];
                    $approved = $gcashReceiptRow['approved'];

                    // Display the Gcash receipt image with an id
                    echo '<img id="gcashImage" src="' . $gcashReceiptPath . '" alt="Gcash Receipt" width="100px" onclick="openModal()">';

                    if ($approved == 0) {
                        // Add radio button for approval only if not already approved
                        echo '<br>';
                        echo 'Approved: ';
                        echo '<input type="radio" name="approval_status" value="1"> Yes ';
                        echo '<input type="radio" name="approval_status" value="0" checked> No ';

                        // Add hidden input for Gcash receipt id
                        echo '<input type="hidden" name="gcash_receipt_id" value="' . $gcashReceiptId . '">';
                    }
                } else {
                    echo 'No Gcash receipt found';
                }
            } else {
                echo 'Pending upload';
            }

            // Initialize $approved if it's not set
            $approved = isset($approved) ? $approved : 0;
            ?>
        </td>
    </tr>
<?php endif; ?>


<form action="" method="POST" onsubmit="return validateStatusChange();">

<div id="gcashModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="gcashImage">
</div>



                <tr>
                    <td>Message:</td>
                    <td><strong><?php echo $message; ?></strong></td>
                </tr>

                <tr>
        <td>Status: </td>
        <td>
            <?php if ($paymentMethod !== 'Gcash' || ($paymentMethod === 'Gcash' && $approved == 1)): ?>
                <select name="status" <?php echo ($order_receive == 1) ? 'disabled' : ''; ?>>
                    <option value="0" <?php if ($status == 0) echo 'selected'; ?>>Pending</option>
                    <option value="1" <?php if ($status == 1) echo 'selected'; ?>>Packed</option>
                    <option value="2" <?php if ($status == 2) echo 'selected'; ?>>For Delivery</option>
                    <option value="3" <?php if ($status == 3) echo 'selected'; ?>>On the Way</option>
                    <option value="4" <?php if ($status == 4) echo 'selected'; ?>>Delivered</option>
                    <option value="5" <?php if ($status == 5) echo 'selected'; ?>>Cancelled</option>
                </select>
                <!-- Add hidden input for status when dropdown is disabled -->
                <input type="hidden" name="hidden_status" value="<?php echo $status; ?>">
                <?php if ($status == 4): ?>
                <br>
                Order Received: 
                <input type="radio" name="order_receive" value="1" <?php if ($order_receive == 1) echo 'checked'; ?>> Yes 
                <input type="radio" name="order_receive" value="0" <?php if ($order_receive == 0) echo 'checked'; ?>> No 
            <?php endif; ?>
        <?php else: ?>
            <select name="status" disabled>
                <option value="0" selected>Pending (Locked)</option>
            </select>
            <!-- Add hidden input for status when dropdown is disabled -->
            <input type="hidden" name="hidden_status" value="<?php echo $status; ?>">
        <?php endif; ?>
        </td>
    </tr>
            </table>

            <table class="tbl-30">
                <?php
                $sql2 = "SELECT op.order_id, 
                    p.name AS product_name, 
                    p.price AS product_price, 
                    p.image_path AS product_image,
                    op.color AS product_color,
                    op.size AS product_size,
                    op.quantity AS product_quantity
                    FROM order_products op
                    JOIN product_list p ON op.product_id = p.id
                    WHERE op.order_id = $id";
                $res2 = mysqli_query($conn, $sql2);
                while ($productRow = mysqli_fetch_assoc($res2)) {
                    $product_name = $productRow['product_name'];
                    $product_color = $productRow['product_color'];
                    $product_size = $productRow['product_size'];
                    $product_quantity = $productRow['product_quantity'];
                    $product_image = $productRow['product_image'];
                    ?>
                    <tr>
                        <td>Product : </td>
                        <td>
                            <img src="<?php echo SITEURL; ?>images/bike/<?php echo $product_image; ?>" width="100px"
                                 alt="<?php echo $product_name; ?>"><br>
                            <?php echo $product_name; ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Color and Size: </td>
                        <td><?php echo $product_color . ', ' . $product_size; ?></td>
                    </tr>

                    <tr>
                        <td>Quantity: </td>
                        <td><?php echo $product_quantity; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>

            <input type="submit" name="submit" value="Update Status" class="btn-secondary">
      
        </form>
        <?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $newStatus = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
    $gcashReceiptId = filter_input(INPUT_POST, 'gcash_receipt_id', FILTER_VALIDATE_INT);

    $order_receive = isset($_POST['order_receive']) ? $_POST['order_receive'] : 0;

     
    // Check if $newStatus is set and not empty
    if ($newStatus !== false && $gcashReceiptId !== false) {
        // Use prepared statements for updating the order status
        $updateSql = "UPDATE order_list SET status = ?, order_receive = ? WHERE id = ? AND client_id = ?";


        // Check if the payment method is 'Gcash' and $approved is 1
        if ($paymentMethod === 'Gcash' && $approved == 1) {
            $updateSql .= " AND status != 5"; // Add condition to prevent updating status for 'Cancelled' orders
        }

        // Use prepared statements to bind parameters
        $stmt = mysqli_prepare($conn, $updateSql);
        $selectSql = "SELECT * FROM order_list WHERE id = $id AND client_id = $userId";
$selectResult = mysqli_query($conn, $selectSql);

if ($selectResult) {
    $row = mysqli_fetch_assoc($selectResult);
    print_r($row); // Check the updated row
} else {
    echo "Select Failed: " . mysqli_error($conn);
}

        // Check if the prepared statement is successful
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "iiii", $newStatus, $order_receive, $id, $userId);

            $updateRes = mysqli_stmt_execute($stmt);

            if ($updateRes) {
                $_SESSION['add'] = "Status updated successfully.";

                // Notification messages based on the new status
                $notificationData = [
                    1 => ["type" => "Packed", "message" => "Your Order Is Packed and ready for delivery."],
                    2 => ["type" => "For Delivery", "message" => "Your Order Is out for delivery."],
                    3 => ["type" => "On the Way", "message" => "Your Order Is on the way."],
                    4 => ["type" => "Delivered", "message" => "Your Order Has Been Delivered Successfully."]
                ];

                if (isset($notificationData[$newStatus])) {
                    $notificationType = $notificationData[$newStatus]["type"];
                    $notificationMessage = $notificationData[$newStatus]["message"];

                    // Insert the notification into the database
                    $userId = isset($_SESSION['client_id']) ? $_SESSION['client_id'] : null;
                    $timestamp = date('Y-m-d H:i:s');
                    $status = "new";
                    $isRead = 0;
                    $promoId = 0; // Replace this with the actual promo ID if applicable

                    $insertNotificationSql = "INSERT INTO notifications (user_id, message, notification_type, timestamp, status, is_read, promo_id) 
                                            VALUES ($userId, '$notificationMessage', '$notificationType', '$timestamp', '$status', $isRead, $promoId)";

                    mysqli_query($conn, $insertNotificationSql);
                }

                // If the new status is 'Cancelled' (status code 5)
                if ($newStatus == 5) {
                    // Get the products from the canceled order
                    $getProductsSql = "SELECT * FROM order_products WHERE order_id = ?";
                    $productsStmt = mysqli_prepare($conn, $getProductsSql);

                    if ($productsStmt) {
                        mysqli_stmt_bind_param($productsStmt, "i", $id);
                        mysqli_stmt_execute($productsStmt);

                        $productsResult = mysqli_stmt_get_result($productsStmt);

                        while ($product = mysqli_fetch_assoc($productsResult)) {
                            $productId = $product['product_id'];
                            $productQuantity = $product['quantity'];

                            // Update the quantity in the stock_list table
                            $updateStockSql = "UPDATE stock_list SET quantity = quantity + ? WHERE product_id = ?";
                            $updateStockStmt = mysqli_prepare($conn, $updateStockSql);

                            if ($updateStockStmt) {
                                mysqli_stmt_bind_param($updateStockStmt, "ii", $productQuantity, $productId);
                                mysqli_stmt_execute($updateStockStmt);
                                mysqli_stmt_close($updateStockStmt);
                            }
                        }

                        mysqli_stmt_close($productsStmt);
                    }
                $userId = isset($_SESSION['client_id']) ? $_SESSION['client_id'] : 0;
                
                $notificationMessage = "Your Order has been Canceled Successfully.";
                $notificationType = "Cancellation";
                $status = "new";
                
                // Set the Manila timezone
                date_default_timezone_set('Asia/Manila');
                
                $timestamp = date('Y-m-d H:i:s', strtotime('now'));
                $isRead = 0;
                $promoId = 0; // Replace this with the actual promo ID if applicable
                
                $insertNotificationSql = "INSERT INTO notifications (user_id, message, notification_type, timestamp, status, is_read, promo_id) 
                                          VALUES ('$userId', '$notificationMessage', '$notificationType', '$timestamp', '$status', '$isRead', '$promoId')";
                
                if (mysqli_query($conn, $insertNotificationSql)) {
                    echo "Record inserted successfully";
                } else {
                    echo "Error inserting record: " . mysqli_error($conn);
                }
                



                    // Redirect to the desired page after canceling the order
                    header('location: ' . SITEURL . 'admin/orders.php');
                    exit(); // Ensure no further code execution after the redirect
                } else {
                    // Redirect to the desired page if the status is not 'Cancelled'
                    header('location: ' . SITEURL . 'admin/orders.php');
                    exit(); // Ensure no further code execution after the redirect
                }
            } else {
                $_SESSION['add'] = "Failed to update status.";
                header('location: ' . SITEURL . 'admin/orders.php');
                exit(); // Ensure no further code execution after the redirect
            }

            // Close the prepared statement
            mysqli_stmt_close($stmt);
        } else {
            // Handle the case where the prepared statement fails
            $_SESSION['add'] = "Failed to update status.";
            header('location: ' . SITEURL . 'admin/orders.php');
            exit(); // Ensure no further code execution after the redirect
        }
    } else {
        $_SESSION['add'] = "Invalid status or Gcash receipt ID.";
        header('location: ' . SITEURL . 'admin/orders.php');
        exit(); // Ensure no further code execution after the redirect
    }
}
?>


    </div>
</div>
<?php

?>

<?php include('partials/footer.php'); ?>

<script>
    function validateStatusChange() {
    var approvalStatus = document.querySelector('input[name="approval_status"]:checked');
    var gcashReceiptId = document.querySelector('input[name="gcash_receipt_id"]').value;

    if (gcashReceiptId === "" && approvalStatus !== null && approvalStatus.value == 1) {
        alertify.error("Please wait for the receipt to be uploaded before changing the status.");
        return false; // Prevent form submission
    }

    return true; // Continue with form submission
}
    function openModal() {
        var gcashImage = document.getElementById('gcashImage');
        var modal = document.getElementById('gcashModal');

        // Set the modal content to the clicked image source
        gcashImage.src = event.target.src;

        // Display the modal
        modal.style.display = 'block';
    }

    function closeModal() {
        document.getElementById('gcashModal').style.display = 'none';
    }
</script>