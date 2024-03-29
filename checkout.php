<?php
include('partials-front/menu.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require 'vendor/autoload.php';

if (!isset($_SESSION['userLoggedIn'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['client_id'];
$totalPrice = 0;
$deliveryOption = '';

?>
<style>
    #orderSummary div {
    margin-bottom: 10px;
}
    .edit-address-container button {
        background-color: black;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }

    .edit-address-container button:hover {
        background-color: orange;
    }
</style>

<br><br>
<body  >

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/themes/default.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>
<style>
   
</style>


<br>
<form method="post">
<div class="container-wrapper">
    <div class="checkout-container">
                <br><br>
            <h1>Checkout</h1>

            <div class="delivery-address">
                <h2>Delivery Address</h2>
                <br>
                <?php
                // Fetch the delivery address for the logged-in user
                $sql = "SELECT * FROM client_list WHERE id = $userId";
                $res = mysqli_query($conn, $sql);

                if ($res == TRUE) {
                    $count = mysqli_num_rows($res);

                    if ($count > 0) {
                        $row = mysqli_fetch_assoc($res);
                        $fullname = $row['fullname'];
                        $contact = $row['contact'];
                        $address = $row['address'];

                        // Pass the user's delivery address to JavaScript
                        echo "<script>";
                        echo "var deliveryAddress = {";
                        echo "    fullname: '" . $fullname . "',";
                        echo "    contact: '" . $contact . "',";
                        echo "    address: '" . $address . "'";
                        echo "};";
                        echo "</script>";
                    }
                }
                ?>
                <p><strong>Name:</strong> <?php echo $fullname; ?></p>
                <p><strong>Contact Number:</strong> <?php echo $contact; ?></p>
                <div class="edit-address-container">
                    <label><strong>Address:</strong> <?php echo $address; ?></label>
                    <button type="button" onclick="editDeliveryAddress()">Edit Address</button>
                </div>
            </div>

            <table class="purchase-order">

                <tr>
                    <th>Product Order</th>
                    <th>Image</th>
                    <th>Color and Size</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>

                <tr>
                    <?php
                $currentTime = date('Y-m-d H:i:s');
                $sql = "SELECT c.id, c.product_id, c.quantity, c.color, c.size, p.name, p.price, p.image_path, d.discount_percentage
               FROM cart_list c
               INNER JOIN product_list p ON c.product_id = p.id
               LEFT JOIN discounts d ON c.product_id = d.product_id AND (d.end_time IS NULL OR d.end_time >= '$currentTime')
               WHERE c.client_id = $userId";
                    $res = mysqli_query($conn, $sql);   
                    $count = mysqli_num_rows($res);
                    $sn = 1;

                    if ($count > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $cart_id = $row['id'];
                            $product_id = $row['product_id'];
                            $product_name = $row['name'];
                            $product_price = $row['price'];
                            $product_quantity = $row['quantity'];
                            $product_total = $product_price * $product_quantity;
                            $product_image = $row['image_path'];
                            $product_color = $row['color'];
                            $product_size = $row['size'];


                            $discount_percentage = $row['discount_percentage'];

                            $discounted_price = $product_price - ($product_price * ($discount_percentage / 100));
                            $product_total = $discounted_price * $product_quantity; // Updated calculation with discount
                            $product_price_display = $discounted_price;

                            ?>
                            <tr>
                                <td><?php echo $product_name; ?></td>
                                <td><?php
                                    if ($product_image == "") {
                                        echo "<div class='error'>Image not Added.</div>";
                                    } else {
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/bike/<?php echo $product_image; ?>"
                                            width="50px">
                                        <?php
                                    }
                                    ?></td>
                                <td><?php echo "Color: " . $product_color . "<br>Size: " . $product_size; ?></td>
                                <td>₱<?php echo number_format($product_price_display); ?></td>
                                <td><?php echo $product_quantity; ?></td>
                                <td>₱<?php echo number_format($product_total); ?></td>
                            </tr>

                            <?php
                            $totalPrice += $product_total;
                        }
                    }

                    ?>
                </tr>
            </table>



            <div class="order-message">
                <label for="order_message">Message:</label>
                <textarea name="order_message" id="order_message" rows="4" cols="50"></textarea>
            </div>
            <br>

            <div class="voucher-container">
                <h2>Your Vouchers</h2>
                <?php
                // Fetch the user's vouchers
                $voucherSql = "SELECT * FROM vouchers WHERE client_id = $userId AND is_redeemed = 0 AND expiration_date >= CURDATE()";
                $voucherResult = mysqli_query($conn, $voucherSql);

                if ($voucherResult && mysqli_num_rows($voucherResult) > 0) {
                    while ($voucher = mysqli_fetch_assoc($voucherResult)) {
                        ?>
                    <label class="voucher-label" onclick="toggleRadioButton(this)">
                            <input type="radio" name="selected_voucher" value="<?php echo $voucher['voucher_id']; ?>">
                            <span class="voucher-code"><?php echo $voucher['code']; ?></span>
                            <span class="voucher-amount">₱<?php echo number_format($voucher['amount'], 2); ?></span>
                        </label>    
                        <?php
                    }
                } else {
                    echo "<p>No available vouchers.</p>";
                }
                ?>
            </div>


            <div class="payment-method">
                <h2>Payment Method</h2>
                <button class="select-payment-button" type="button" onclick="showPaymentButtons()">Select Payment Method</button>
                <div class="payment-buttons">
                    <button class="payment-button" type="button" onclick="showPaymentDetails('Pickup')">Pick Up</button>
                    <button class="payment-button" type="button" onclick="showPaymentDetails('Cash on Delivery')">Cash on Delivery</button>
                    <button class="payment-button" type="button" onclick="showPaymentDetails('Gcash')">Gcash</button>
            </div>
        
        </div>

   

    
     </div>  
        <!-- Keep this hidden input field for payment_method -->
        <input type="hidden" name="payment_method" value="">
        <br>
            <div class="summary-container">
                <h3>Summary</h3>
                        <div class="payment-details">
                        
                            <div id="orderSummary">
                                <!-- Content will be dynamically updated here -->
                            </div>

                                <!-- Remove the duplicate input element -->
                    
                            </div>
                            <!-- Disable the submit button by default -->
                <input type="submit" name="checkout" value="Checkout" class="checkout-btn" disabled>
                <input type="hidden" name="delivery_address" id="delivery_address">
            </div>
    </div>
        <!-- Disable the submit button by default -->
        
</body>

<script>
 function editDeliveryAddress() {
        alertify.prompt('Edit Delivery Address', 'Enter new address:', ''
            , function (evt, value) {
                // User clicked "OK"
                if (value.trim() !== '') {
                    // Update the displayed delivery address
                    document.querySelector('.edit-address-container label').innerHTML = `<strong>Address:</strong> ${value}`;

                    // Update the JavaScript object with the new address
                    deliveryAddress.address = value;

                    // Perform any additional actions if needed
                }
            }
            , function () {
                // User clicked "Cancel"
            }
        );
    }



    
    
    // Create a JavaScript object to store the delivery address
    var deliveryAddress = {
        fullname: "<?php echo $fullname; ?>",
        contact: "<?php echo $contact; ?>",
        address: "<?php echo $address; ?>"
    };

    function showPaymentButtons() {
        
        const paymentButtons = document.querySelector('.payment-buttons');
        paymentButtons.style.display = 'flex';
    }

    function hidePaymentButtons() {
        const paymentButtons = document.querySelector('.payment-buttons');
        paymentButtons.style.display = 'none';
    }

    function updateDeliveryAddress() {
    const newDeliveryAddressInput = document.getElementById('new_delivery_address');
    const deliveryAddressParagraph = document.querySelector('.delivery-address p:last-child');

    if (newDeliveryAddressInput.value.trim() !== '') {
        // Update the displayed delivery address
        deliveryAddressParagraph.innerHTML = `<strong>Address:</strong> ${newDeliveryAddressInput.value}`;

        // Update the JavaScript object with the new address
        deliveryAddress.address = newDeliveryAddressInput.value;

        // Clear the input field
        newDeliveryAddressInput.value = '';
    }
}


    function showPaymentDetails(paymentMethod) {
    const paymentDetails = document.querySelector('.payment-details');
    const paymentMethodInput = document.querySelector('input[name="payment_method"]');
    const deliveryAddressInput = document.querySelector('input[name="delivery_address"]');
    const orderMessageTextarea = document.querySelector('textarea[name="order_message"]');
    const additionalFee = 300; // Additional fee for Cash on Delivery

    // Check if a voucher is selected
    const selectedVoucher = document.querySelector('input[name="selected_voucher"]:checked');
    let voucherAmount = 0;

    if (selectedVoucher) {
        voucherAmount = parseFloat(selectedVoucher.parentNode.querySelector('.voucher-amount').innerText.replace('₱', ''));
    }

    if (paymentMethodInput) {
        let totalWithFee = <?php echo $totalPrice; ?>; // Initial total without fee

        if (paymentMethod === 'Cash on Delivery') {
            const maxQuantityForCOD = 5;
            let totalQuantity = 0;

            // Calculate the total quantity in the cart
            <?php
            $cartItemsSql = "SELECT SUM(quantity) AS total_quantity FROM cart_list WHERE client_id = $userId";
            $cartItemsResult = mysqli_query($conn, $cartItemsSql);
            if ($cartItemsResult) {
                $totalQuantity = mysqli_fetch_assoc($cartItemsResult)['total_quantity'];
            }
            ?>
            totalQuantity = <?php echo $totalQuantity; ?>;

            if (totalQuantity > maxQuantityForCOD) {
                alertify.alert('Exceeded Cash on Delivery Quantity Limit', 'Cash on Delivery quantity is limited to 5 items. Please reduce the quantity or choose another payment method.');
                return;
            }

            totalWithFee += additionalFee; // Add the additional fee for COD
        }

        // Deduct the voucher amount from the total
        totalWithFee -= voucherAmount;

        const formattedTotalWithFee = new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP'
        }).format(totalWithFee);

        orderMessageTextarea.value = orderMessageTextarea.value;

        // Set the delivery_address input value
        deliveryAddressInput.value = JSON.stringify(deliveryAddress.address);

        const orderSummary = document.getElementById('orderSummary');
        orderSummary.innerHTML = `
            <div><strong>Selected Payment Method:</strong> ${paymentMethod}</div>
            <div><strong>Name:</strong> ${deliveryAddress.fullname}</div>
            <div><strong>Contact Number:</strong> ${deliveryAddress.contact}</div>
            <div><strong>Address:</strong> ${deliveryAddress.address}</div>
            ${paymentMethod === 'Cash on Delivery' ? `<div><strong>Additional Fee (Shipping):</strong> ₱${additionalFee}</div>` : ''}
            ${voucherAmount > 0 ? `<div><strong>Discount (Voucher):</strong> -₱${voucherAmount}</div>` : ''}
            <div><strong>Total Price:</strong> ${formattedTotalWithFee}</div>
            ${paymentMethod === 'Gcash' ? `<div><em>Please note: Payment will be done upon checkout.</em></div>` : ''}
        `;

        hidePaymentButtons();

        paymentMethodInput.value = paymentMethod;

        document.querySelector('input[name="checkout"]').disabled = false;
    }
}




</script>
</html>

<?php
function createVoucher($userId) {
    global $conn;

    // Check if the user has any unredeemed vouchers that have not expired
    $existingVoucherSql = "SELECT * FROM vouchers WHERE client_id = ? AND is_redeemed = 0 AND expiration_date >= CURDATE()";
    $existingVoucherStmt = mysqli_prepare($conn, $existingVoucherSql);
    mysqli_stmt_bind_param($existingVoucherStmt, "i", $userId);
    mysqli_stmt_execute($existingVoucherStmt);
    $existingVoucherResult = mysqli_stmt_get_result($existingVoucherStmt);

    if (!$existingVoucherResult || mysqli_num_rows($existingVoucherResult) == 0) {
        // Generate a new voucher only if there are no unredeemed vouchers
        // Check the user's purchase history
        $purchaseHistorySql = "SELECT COUNT(*) as total_orders FROM order_list WHERE client_id = ?";
        $purchaseHistoryStmt = mysqli_prepare($conn, $purchaseHistorySql);
        mysqli_stmt_bind_param($purchaseHistoryStmt, "i", $userId);
        mysqli_stmt_execute($purchaseHistoryStmt);
        $purchaseHistoryResult = mysqli_stmt_get_result($purchaseHistoryStmt);

        if ($purchaseHistoryResult) {
            $totalOrders = mysqli_fetch_assoc($purchaseHistoryResult)['total_orders'];

            //  
            if ($totalOrders >= 2 && $totalOrders < 6) {
                // Check if the user already has a voucher with the same amount
                $existingVoucherAmountSql = "SELECT * FROM vouchers WHERE client_id = ? AND amount = 200  AND expiration_date >= CURDATE()";
                $existingVoucherAmountStmt = mysqli_prepare($conn, $existingVoucherAmountSql);
                mysqli_stmt_bind_param($existingVoucherAmountStmt, "i", $userId);
                mysqli_stmt_execute($existingVoucherAmountStmt);
                $existingVoucherAmountResult = mysqli_stmt_get_result($existingVoucherAmountStmt);

                if (!$existingVoucherAmountResult || mysqli_num_rows($existingVoucherAmountResult) == 0) {
                    // Generate a voucher code (you may use any logic to create a unique code)
                    $voucherCode = generateVoucherCode();

                    // Set voucher amount to 200
                    $voucherAmount = 200;

                    // Set expiration date to 7 days from now
                    $expirationDate = date('Y-m-d', strtotime('+7 days'));

                    // Insert voucher into the vouchers table
                    $insertVoucherSql = "INSERT INTO vouchers (code, client_id, amount, expiration_date) 
                                         VALUES (?, ?, ?, ?)";
                    $insertVoucherStmt = mysqli_prepare($conn, $insertVoucherSql);
                    mysqli_stmt_bind_param($insertVoucherStmt, "sids", $voucherCode, $userId, $voucherAmount, $expirationDate);
                    mysqli_stmt_execute($insertVoucherStmt);

                    // Return the voucher details (you may modify this based on your needs)
                    return [
                        'code' => $voucherCode,
                        'amount' => $voucherAmount,
                        'expiration_date' => $expirationDate
                    ];
                }
            } elseif ($totalOrders >= 5) {
                // Check if the user already has a voucher with the same amount
                $existingVoucherAmountSql = "SELECT * FROM vouchers WHERE client_id = ? AND amount = 400  AND expiration_date >= CURDATE()";
                $existingVoucherAmountStmt = mysqli_prepare($conn, $existingVoucherAmountSql);
                mysqli_stmt_bind_param($existingVoucherAmountStmt, "i", $userId);
                mysqli_stmt_execute($existingVoucherAmountStmt);
                $existingVoucherAmountResult = mysqli_stmt_get_result($existingVoucherAmountStmt);

                if (!$existingVoucherAmountResult || mysqli_num_rows($existingVoucherAmountResult) == 0) {
                    // Generate a voucher code (you may use any logic to create a unique code)
                    $voucherCode = generateVoucherCode();

                    // Set voucher amount to 400
                    $voucherAmount = 400;

                    // Set expiration date to 7 days from now
                    $expirationDate = date('Y-m-d', strtotime('+7 days'));

                    // Insert voucher into the vouchers table
                    $insertVoucherSql = "INSERT INTO vouchers (code, client_id, amount, expiration_date) 
                                         VALUES (?, ?, ?, ?)";
                    $insertVoucherStmt = mysqli_prepare($conn, $insertVoucherSql);
                    mysqli_stmt_bind_param($insertVoucherStmt, "sids", $voucherCode, $userId, $voucherAmount, $expirationDate);
                    mysqli_stmt_execute($insertVoucherStmt);

                    // Return the voucher details (you may modify this based on your needs)
                    return [
                        'code' => $voucherCode,
                        'amount' => $voucherAmount,
                        'expiration_date' => $expirationDate
                    ];
                }
            }
        }
    }

    return null;
}


function generateVoucherCode($length = 8) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';

    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $code;
}

if (isset($_POST['checkout'])) {
  
    // Step 1: Insert a new order record into order_list
    $refCode = "ORD_" . date("YmdHis") . "_" . $userId;
    $paymentMethod = isset($_POST['payment_method']) ? mysqli_real_escape_string($conn, $_POST['payment_method']) : '';
    $deliveryAddress = isset($_POST['delivery_address']) ? mysqli_real_escape_string($conn, $_POST['delivery_address']) : '';
    $orderMessage = isset($_POST['order_message']) ? mysqli_real_escape_string($conn, $_POST['order_message']) : '';

    $additionalFee = 0;

    if ($paymentMethod === 'Cash on Delivery') {
        $additionalFee = 300;
    }

    $totalPrice += $additionalFee;

    if (isset($_POST['selected_voucher'])) {
        $selectedVoucherId = mysqli_real_escape_string($conn, $_POST['selected_voucher']);
    
        // Retrieve voucher details
        $voucherDetailsSql = "SELECT * FROM vouchers WHERE voucher_id = $selectedVoucherId AND client_id = $userId AND is_redeemed = 0 AND expiration_date >= CURDATE()";
        $voucherDetailsResult = mysqli_query($conn, $voucherDetailsSql);
    
        if ($voucherDetailsResult && mysqli_num_rows($voucherDetailsResult) > 0) {
            $voucherDetails = mysqli_fetch_assoc($voucherDetailsResult);
            $voucherAmount = $voucherDetails['amount'];
    
            // Deduct the voucher amount from the total price
            $totalPrice -= $voucherAmount;
    
            // Update the voucher as redeemed
            $redeemVoucherSql = "UPDATE vouchers SET is_redeemed = 1, redeemed_date = CURDATE() WHERE voucher_id = $selectedVoucherId";
            mysqli_query($conn, $redeemVoucherSql);
        }
    }

  
    $timenow = date('Y-m-d H:i:s');
    $insertOrderSql = "INSERT INTO order_list (ref_code, client_id, total_amount, delivery_address, payment_method, message, status, order_receive, date_created)
    VALUES ('$refCode', $userId, $totalPrice, '$deliveryAddress', '$paymentMethod', '$orderMessage', 0, 0, '$timenow')";

        $createdVoucher = createVoucher($userId);   
        if ($createdVoucher) {
            // Create a notification
            $notificationvoucher = "Congratulations! You\'ve earned a voucher. Code: " . mysqli_real_escape_string($conn, $createdVoucher['code']);
            $notificationType = "Voucher";
            $timestamp = date('Y-m-d H:i:s');
            $status = "new";
            $isRead = 0;
            $promoId = 0; // Replace this with the actual promo ID if applicable

            $insertNotificationSql = "INSERT INTO notifications (user_id, message, notification_type, timestamp, status, is_read, promo_id) 
                                    VALUES ($userId, '$notificationvoucher', '$notificationType', '$timestamp', '$status', $isRead, $promoId)";

            if (mysqli_query($conn, $insertNotificationSql)) {
                // Notification created successfully, you can handle additional logic if needed
            } else {
                // Handle the insert notification query error
                echo "Error creating voucher notification: " . mysqli_error($conn);
            }
        }

        
    


    if (mysqli_query($conn, $insertOrderSql)) {
        // Step 2: Retrieve the order_id of the newly inserted order
        $orderId = mysqli_insert_id($conn);

        // Step 3: Retrieve the cart items
        $cartItemsSql = "SELECT * FROM cart_list WHERE client_id = $userId";
        $cartItemsResult = mysqli_query($conn, $cartItemsSql);

        $notificationMessage = "Your order has been placed successfully. Your order reference code is: $refCode";
        $notificationType = "Order";
        $timestamp = date('Y-m-d H:i:s');
        $status = "new";
        $isRead = 0;
        $promoId = 0; // Replace this with the actual promo ID if applicable

        $insertNotificationSql = "INSERT INTO notifications (user_id, message, notification_type, timestamp, status, is_read, promo_id) 
                                  VALUES ($userId, '$notificationMessage', '$notificationType', '$timestamp', '$status', $isRead, $promoId)";

        if (!mysqli_query($conn, $insertNotificationSql)) {
            // Handle the insert notification query error
            mysqli_rollback($conn);
            echo "Error inserting notification record: " . mysqli_error($conn);
            exit;
        }

        $insertAdminNotificationSql = "INSERT INTO admin_notifications (order_id, order_products_id, notification_type, is_approved, is_read, timestamp) 
        VALUES ($orderId, $product_id, 'order', 1, 0, current_timestamp())";

            if (!mysqli_query($conn, $insertAdminNotificationSql)) {
            // Handle the insert admin notification query error
            mysqli_rollback($conn);
            echo "Error inserting admin notification record: " . mysqli_error($conn);
            exit;
            }


        while ($cartItem = mysqli_fetch_assoc($cartItemsResult)) {
            $productId = $cartItem['product_id'];
            $quantity = $cartItem['quantity'];
            $color = $cartItem['color'];
            $size = $cartItem['size'];

            // Retrieve product price from product_list based on product_id
            $productPriceSql = "SELECT price FROM product_list WHERE id = $productId";
            $productPriceResult = mysqli_query($conn, $productPriceSql);
            $productPrice = mysqli_fetch_assoc($productPriceResult)['price'];

            // Insert the cart item into order_products
            $insertOrderProductSql = "INSERT INTO order_products (order_id, product_id, quantity, price_per_unit, color, size)
                                      VALUES ($orderId, $productId, $quantity, $productPrice, '$color', '$size')";

            if (!mysqli_query($conn, $insertOrderProductSql)) {
                // Handle the insert order product query error
                mysqli_rollback($conn);
                echo "Error inserting order product record: " . mysqli_error($conn);
                exit;
            }

            // Update the stock_list table to deduct the quantity
            $updateStockSql = "UPDATE stock_list AS sl
                        INNER JOIN product_colors_sizes AS pcs ON sl.product_colors_sizes_id = pcs.id
                        SET sl.quantity = sl.quantity - $quantity 
                        WHERE pcs.product_id = $productId AND pcs.color = '$color' AND pcs.size = '$size'";
            if (!mysqli_query($conn, $updateStockSql)) {
                // Handle the update stock query error
                mysqli_rollback($conn);
                echo "Error updating stock records: " . mysqli_error($conn);
                exit;
                
            }
        }

    


      

        // Step 4: Commit the changes
        mysqli_commit($conn);
        $id = $orderId;


        $sql1 = "SELECT * FROM client_list WHERE id = $userId";
        $result = mysqli_query($conn, $sql1);
        if ($result && mysqli_num_rows($result) > 0) {
            $clientData = mysqli_fetch_assoc($result);
            $clientEmail = $clientData['email'];
    
            $to = $clientEmail; // Client's email address
            $subject = "Order Receipt";
    
            // Modify the HTML content to include an image and enhanced design
            $mailContent = '<!DOCTYPE html>
            <html>
            <head>
                <title>Order Receipt</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        padding: 20px;
                    }
                    .container {
                        border: 1px solid #ccc;
                        border-radius: 5px;
                        padding: 20px;
                        margin-bottom: 20px;
                    }
                    .product-img {
                        max-width: 100px;
                        max-height: 100px;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h2>Hello, ' . $fullname . '!</h2>
                    <p>Thank you for your order. Your order reference code is: <strong>' . $refCode . '</strong></p>
                    <p>Total amount: ₱' . $totalPrice . '</p>
                </div>';
    
            // Add the product details to the email content
            $mailContent .= '<div class="container">';
            $mailContent .= '<h3>Products Ordered:</h3>';
            // Retrieve the cart items with product details
            $cartItemsSql = "SELECT c.product_id, c.quantity, c.color, c.size, p.name, p.price, p.image_path 
            FROM cart_list c 
            INNER JOIN product_list p 
            ON c.product_id = p.id 
            WHERE c.client_id = $userId";
            $cartItemsResult = mysqli_query($conn, $cartItemsSql);
                
    
            while ($cartItem = mysqli_fetch_assoc($cartItemsResult)) {
                // Get the product details
                  $productName = $cartItem['name'];
                $productImage = SITEURL . 'images/bike/' . $cartItem['image_path'];
                $productPrice = $cartItem['price'];
                $productQuantity = $cartItem['quantity'];
                $productTotal = $productPrice * $productQuantity;
                $productColor = $cartItem['color'];
                $productSize = $cartItem['size'];
    
                // Add product details to the email content
                $mailContent .= '<div>';
                $mailContent .= '<img src="' . $productImage . '" alt="' . $productName . '" class="product-img">';
                $mailContent .= '<p>Name: ' . $productName . '</p>';
                $mailContent .= '<p>Color: ' . $productColor . '</p>';
                $mailContent .= '<p>Size: ' . $productSize . '</p>';
                $mailContent .= '<p>Price: ₱' . $productPrice . '</p>';
                $mailContent .= '<p>Quantity: ' . $productQuantity . '</p>';
                $mailContent .= '<p>Total: ₱' . $productTotal . '</p>';
                $mailContent .= '</div>';
            }
            $mailContent .= '</div>';
    
            // Add the closing tags and signature
            $mailContent .= '
                <p>Thank you for shopping with us!</p>
                <p>Regards,</p>
                <p>Skid Alley</p>
            </body>
            </html>';
    
           
    
            
    
            $mail = new PHPMailer(true);
            try 
            {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Set your SMTP host
                $mail->SMTPAuth = true;
                $mail->Username = 'iansalgado567@gmail.com'; // Set your SMTP username
                $mail->Password = 'obid wjcj ztjv nhbm';  // SMTP password
                $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587; // TCP port to connect to
    
                $mail->setFrom('your_email@example.com', 'Skid Alley');
                $mail->addAddress($to); // Add a recipient
    
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body = $mailContent;
    
                $mail->send();
                echo 'Message has been sent';

                $clearCartSql = "DELETE FROM cart_list WHERE client_id = $userId";
                mysqli_query($conn, $clearCartSql);
            } 

            catch (Exception $e) 
            {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } 
        else {
            echo 'Client data not found.';
        }

        // Redirect to the order status page
        header("Location: " . SITEURL . "orderstatus.php?id=$id");
        exit();

    } else {
        // Handle the insert order query error
        mysqli_rollback($conn);
        echo "Error inserting order record: " . mysqli_error($conn);
    }
      
     
 
}

?>


<br><br><br>
<?php include('partials-front/footer.php'); ?>
