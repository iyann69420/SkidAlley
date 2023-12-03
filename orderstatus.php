        <?php
        $gcashReceiptUploaded = isset($_SESSION['gcashReceiptUploaded']) && $_SESSION['gcashReceiptUploaded'];
        include('partials-front/menu.php');

        if (!isset($_SESSION['userLoggedIn'])) {
            header("Location: login.php");
            exit();
            
        }
        if (isset($_SESSION['reviewSubmitted']) && $_SESSION['reviewSubmitted']) {
            echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js'></script>";
            echo "<script>alertify.success('Review submitted successfully!');</script>";
        
            // Reset the session variable to avoid showing the message again on page refresh
            $_SESSION['reviewSubmitted'] = false;
        }

        if (isset($_SESSION['gcashReceiptUploaded']) && $_SESSION['gcashReceiptUploaded']) {
            echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js'></script>";
            echo "<script>alertify.success('Receipt uploaded successfully!');</script>";
        
            // Reset the session variable to avoid showing the message again on page refresh
            $_SESSION['gcashReceiptUploaded'] = false;
        }

        if (isset($_SESSION['failed']) && $_SESSION['failed']) {
            echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js'></script>";
            echo "<script>alertify.error('You already send a detail');</script>";
        
            // Reset the session variable to avoid showing the message again on page refresh
            $_SESSION['failed'] = false;
        }
   

        ?>


        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>My Purchase</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
        

            <style>
            
            </style>
        
        </head>
        <body>


        <div class="status-buttons">
            <button onclick="filterOrders('All')">All</button>
            <button onclick="filterOrders('Pending')">Pending</button>
            <button onclick="filterOrders('Packed')">Packed</button>
            <button onclick="filterOrders('For Delivery')">For Delivery</button>
            <button onclick="filterOrders('On the Way')">On the Way</button>
            <button onclick="filterOrders('Delivered')">Delivered</button>
            <button onclick="filterOrders('Cancelled')">Cancelled</button>
         
            
        </div>
        <br>
        <?php
        if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn']) {
            $client_id = $_SESSION['client_id'];

            $sql = "SELECT * FROM order_list WHERE client_id = $client_id";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $ref_code = $row['ref_code'];
                    $client_id = $row['client_id'];
                    $total_amount = $row['total_amount'];
                    $deliveryAddress = $row['delivery_address'];
                    $paymentMethod = $row['payment_method'];
                    $status = $row['status'];
                    $date_ordered = $row['date_created'];

                    

                    
                    $statusText = [
                        0 => 'Pending',
                        1 => 'Packed',
                        2 => 'For Delivery',
                        3 => 'On the Way',
                        4 => 'Delivered',
                        5 => 'Cancelled',
                        
                    ];
                    
                    // Get the corresponding text for the status
                    $statusTextValue = isset($statusText[$status]) ? $statusText[$status] : 'Unknown';
                    ?>
                    
            
                    <div class="container" data-status="<?php echo strtolower($statusTextValue); ?>">
                    
                        <table class="my-purchase">
                            <article class="card">
                                <header class="card-header"> My Orders / Tracking </header>
                                <div class="card-body">
                                    <h6>Order ID: <?php echo $ref_code ?></h6>
                                    <article class="card">
                                        <div class="card-body row">
                                        <div class="col">
                                        <strong>Estimated Delivery time:</strong> <br>
                                        <?php
                                        // Assuming $date_ordered is a valid date in a format like "YYYY-MM-DD"
                                        $deliveryDate = '';

                                        switch ($statusTextValue) {
                                            case 'Pending':
                                                $deliveryDate = date('Y-m-d', strtotime($date_ordered . ' +1 day'));
                                                break;

                                            case 'Packed':
                                                $deliveryDate = date('Y-m-d', strtotime($date_ordered . ' +1 day'));
                                                break;

                                            case 'For Delivery':
                                                $deliveryDate = date('Y-m-d', strtotime($date_ordered . ' +1 day'));
                                                break;

                                            case 'On the Way':
                                                $deliveryDate = date('Y-m-d', strtotime($date_ordered . ' +3 days'));
                                                break;

                                            case 'Delivered':
                                                // Customize as needed for the Delivered status
                                                $deliveryDate = date('Y-m-d', strtotime($date_ordered . ' +1 day'));
                                                break;

                                            case 'Cancelled':
                                                // Customize as needed for the Cancelled status
                                                $deliveryDate = 'N/A'; // or any other message for cancelled orders
                                                break;

                                            default:
                                                $deliveryDate = 'Unknown';
                                                break;
                                        }

                                        echo $deliveryDate;
                                        ?>
                                    </div>
                                    <div class="col">
                                        <?php  
                                        $gcashSql = "SELECT * FROM gcash_infos";
                                        $gcashRes = mysqli_query($conn, $gcashSql);
                                        $gcashCount = mysqli_num_rows($gcashRes);
                                        
                                        if ($gcashCount > 0) {
                                            while ($gcashRow = mysqli_fetch_assoc($gcashRes)) {
                                                $name = $gcashRow['name'];
                                                $number = $gcashRow['number'];
                                                ?>
                                                <strong>Shipping BY:</strong> <br>
                                                <?php echo $name; ?> | <i class="fa fa-phone"></i> <?php echo $number; ?>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>

                                            <div class="col status"> <strong>Status:</strong> <br><?php echo $statusTextValue ?> </div>
                                            <div class="col"> <strong>Total Amount:</strong> <br>₱<?php echo number_format($total_amount); ?> </div>
                                            <div class="col"> <strong>Payment Details:</strong> <br><?php echo $paymentMethod ?> </div>
                                    </article>


                                    <div class="track">
                                        <?php
                                        // Define the mapping of status values to text labels and icons
                                        $statusData = [
                                            0 => ['text' => 'Pending', 'icon' => 'fa-hourglass-half'],
                                            1 => ['text' => 'Packed', 'icon' => 'fa-archive'],
                                            2 => ['text' => 'For Delivery', 'icon' => 'fa-user'],
                                            3 => ['text' => 'On the Way', 'icon' => 'fa-truck'],
                                            4 => ['text' => 'Delivered', 'icon' => 'fa-check'],
                                        
                                        ];

                                        // Get the status value from your database, assuming it's stored in $status
                                        $statusFromDatabase = $row['status']; // You need to fetch the status from your database here.

                                        // Iterate through the possible status values and display each step
                                        foreach ($statusData as $statusValue => $statusInfo) {
                                            $isActive = ($statusFromDatabase >= $statusValue); // Check if the status is greater than or equal to the current step.
                                            $stepClass = $isActive ? 'step active' : 'step';
                                            ?>
                                            <div class="<?php echo $stepClass; ?>">
                                                <span class="icon"><i class="fa <?php echo $statusInfo['icon']; ?>"></i></span>
                                                <span class="text"><?php echo $statusInfo['text']; ?></span>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                
                                    <hr>
                            <ul class="row">

                            <?php

                                $order_id = $row['id']; // Assuming you have an 'order_id' column in your 'order_list' table

                                $query = "SELECT op.order_id, 
                                        p.name AS product_name, 
                                        p.price AS product_price, 
                                        d.discount_percentage AS product_discount,  
                                        p.image_path AS product_image,
                                        op.color AS product_color,
                                        op.size AS product_size,
                                        op.quantity AS product_quantity
                                FROM order_products op
                                JOIN product_list p ON op.product_id = p.id
                                LEFT JOIN discounts d ON p.id = d.product_id  
                                WHERE op.order_id = $order_id";


                                // Use a different variable for the result set of the inner query
                                $resInner = mysqli_query($conn, $query);

                                // Fetch product details from the inner result set
                                while ($productRow = mysqli_fetch_assoc($resInner)) {
                                    $product_name = $productRow['product_name'];
                                    $product_price = $productRow['product_price'];
                                    $product_image = $productRow['product_image'];
                                    $product_color = $productRow['product_color'];
                                    $product_size = $productRow['product_size'];
                                    $product_quantity = $productRow['product_quantity'];

                                    $discounted_price = null;
                                    if (!empty($product_discount)) {
                                        $discounted_price = $product_price - ($product_price * $product_discount / 100);
                                        $discounted_price = number_format($discounted_price, 2); // Format to 2 decimal places
                                    }
                                
                                    ?>
                                    <li class="col-md-4">
                                        <figure class="itemside mb-3">
                                            <div class="aside">
                                            <?php
                                            if (empty($product_image)) {
                                                echo "<div class='error'>Image not Added.</div>";
                                            } else {
                                                ?>
                                                <img src="<?php echo SITEURL; ?>images/bike/<?php echo $product_image; ?>" width="100px" alt="<?php echo $product_name; ?>">
                                            <?php
                                            }
                                            ?>
                                            </div>
                                            <figcaption class="info align-self-center">
                                            <p class="title"><?php echo $product_name; ?></p>
                                            <span class="text-muted">Color: <?php echo $product_color; ?></span>
                                            <br>
                                            <span class="text-muted">Size: <?php echo $product_size; ?></span>
                                            <br>
                                            <span class="text-muted">Quantity: <?php echo $product_quantity; ?></span>
                                            <br>
                                          
                                                
                                                
                                        
                                        </figcaption>
                                        </figure>
                                    </li>
                                    <?php
                                }

                            ?>
                            


 

                            </ul>
                                    <hr>
                                    <?php 
                                   if ($statusTextValue === 'Pending') {
                                    $formButton = "<button type=\"button\" onclick=\"confirmCancelOrder($order_id)\" class=\"btn btn-warning\" data-abc=\"true\">Cancel Order</button>";
                                
                                    // Check if this order has a pending cancellation request
                                    $checkCancellationSql = "SELECT * FROM admin_notifications WHERE order_id = $order_id AND is_approved = 0";
                                    $cancellationResult = mysqli_query($conn, $checkCancellationSql);
                                
                                    if (mysqli_num_rows($cancellationResult) > 0) {
                                        $formButton = "Cancellation Pending";
                                    }
                                
                                    // Render the form button based on the conditions
                                    if (mysqli_num_rows($cancellationResult) <= 0) {
                                        echo "<form method=\"post\" action=\"request-cancellation.php\" id=\"cancelOrderForm_$order_id\">";
                                        echo "<input type=\"hidden\" name=\"order_id\" value=\"$order_id\">";
                                        echo "<input type=\"hidden\" name=\"order_products_id\" value=\"" . (isset($productRow['order_products_id']) ? $productRow['order_products_id'] : '') . "\">";
                                        echo "<input type=\"hidden\" name=\"reason\" id=\"reasonInput_$order_id\">";
                                        echo $formButton;
                                        echo "</form>";
                                
                                        // Add the button specifically for Gcash payment
                                        // Add the button specifically for Gcash payment
                                        if ($paymentMethod === 'Gcash') {
                                            // Check if gcash_receipts_id exists for the given order_id
                                            $orderIdExistsInGcashReceipts = false; // Initialize the variable
                                
                                            $checkGcashReceiptsQuery = "SELECT o.id, g.id AS gcash_id, g.approved
                                                                        FROM order_list o
                                                                        LEFT JOIN gcash_receipts g ON o.gcash_receipts_id = g.id
                                                                        WHERE o.id = $order_id";
                                
                                            $result = mysqli_query($conn, $checkGcashReceiptsQuery);
                                
                                            if ($result) {
                                                $row = mysqli_fetch_assoc($result);
                                
                                                // Check if gcash_id is not null and approved is not equal to 1
                                                if (!is_null($row['gcash_id']) && $row['approved'] != 1) {
                                                    // There is a corresponding entry in gcash_receipts for the given order_id
                                                    echo '<span style="color: orange; margin-left: 10px;">Pending</span>';
                                                } elseif ($row['approved'] == 1) {
                                                    // Gcash receipt is already approved
                                                    echo '<span style="color: green; margin-left: 10px;">Approved</span>';
                                                } else {
                                                    // There is no corresponding entry in gcash_receipts for the given order_id
                                                    echo "<button type=\"button\" onclick=\"uploadGcashReceipt($order_id)\" class=\"btn btn-success ml-4\">Pay Gcash</button>";
                                                }
                                            } else {
                                                echo "Error querying the database: " . mysqli_error($conn);
                                            }
                                }

                                    } else {
                                        echo $formButton;
                                    }
                                } 
                                
                                if ($statusTextValue === 'Delivered') {
                                    if ($row['order_receive'] == 0) {
                                        // If the order has not been received
                                        echo "<button type=\"button\" onclick=\"confirmOrderReceived($order_id)\" class=\"btn btn-primary\" data-abc=\"true\">Order Received</button>";
                                    } else {
                                        // If the order has been received, check if there is a review for this order
                                        $checkReviewSql = "SELECT * FROM reviews WHERE order_id = $order_id";
                                        $reviewResult = mysqli_query($conn, $checkReviewSql);
                                
                                        if (mysqli_num_rows($reviewResult) > 0) {
                                            echo "<p>Product reviewed</p>";
                                        } else {
                                            // If there is no review, change the button to review product
                                            echo "<button type=\"button\" onclick=\"redirectToReviewPage($order_id)\" class=\"btn btn-success\" data-abc=\"true\">Review Product</button>";
                                        }
                                    }
                                }
                                    ?>
                                </div>
                            </article>

                        </div>
                    </table>
                    </div>
                    
            
                    <?php
                }
            }
        }
        ?>

        <?php include('partials-front/footer.php'); ?>


        <?php
            if (isset($_GET['error'])) {
                echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js'></script>";
                echo "<script>alertify.error('" . $_GET['error'] . "');</script>";
            } elseif (isset($_GET['success'])) {
                echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js'></script>";
                echo "<script>alertify.success('" . $_GET['success'] . "');</script>";
            }
            ?>



        </body>
        </html>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/themes/default.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    
   






        <script defer>

        
        function uploadGcashReceipt(orderId) {
            // Assuming you have a PHP script to handle the receipt upload, replace 'upload-receipt.php' with the actual script
            let uploadURL = 'upload-receipt.php?order_id=' + orderId;

            // Redirect the user to the upload receipt page
            window.location.href = uploadURL;
        }







        function confirmCancelOrder(orderId) {
            alertify.prompt('Please provide a reason for cancellation', '', function (evt, value) {
                if (value.trim() === '') {
                    alertify.error('Please provide a reason for cancellation.');
                } else {
                    let reasonInput = document.getElementById(`reasonInput_${orderId}`);
                    let cancelOrderForm = document.getElementById(`cancelOrderForm_${orderId}`);
                    if (reasonInput && cancelOrderForm) {
                        reasonInput.value = value;
                        cancelOrderForm.submit();
                    } else {
                        alertify.error('An error occurred while processing your request.');
                    }
                }
            }, function () {
                // User clicked cancel for providing a reason
            });
        }

        function redirectToReviewPage(orderId) {
            // Assuming the review page is named 'review.php'
            // You can replace this with the actual URL of your review page
            let reviewPageURL = 'review.php?order_id=' + orderId;
            window.location.href = reviewPageURL;
        }

        function confirmOrderReceived(orderId) {
        // Display a confirmation dialog using Alertify.js
        alertify.confirm('Confirm Order Received', 'Have you received your order?', 
            function () {
                // User clicked 'OK'
                // Assuming you have a PHP script to handle the update, replace 'update-order-received.php' with the actual script
                let updateURL = 'update-order-received.php?order_id=' + orderId;

                // Use AJAX to send a request to the server
                let xhr = new XMLHttpRequest();
                xhr.open('GET', updateURL, true);

                // Set up a callback function to handle the response
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        // Update the button text or perform any other action
                        alertify.success('Order Received successfully updated.');
                        // Optionally, you can reload the page or update the UI as needed
                        location.reload();
                    } else {
                        alertify.error('Error updating order status.');
                    }
                };

                // Set up a callback function to handle errors
                xhr.onerror = function () {
                    alertify.error('An error occurred while processing your request.');
                };

                // Send the AJAX request
                xhr.send();
            },
            function () {
                // User clicked 'Cancel'
                // Do nothing or provide any additional action if needed
            }
        );
    }


    function filterOrders(status) {
        let allOrders = document.querySelectorAll('.container');
        let anyOrdersDisplayed = false; // Keep track if any orders were displayed

        allOrders.forEach((currentOrder) => {
            let orderStatus = currentOrder.dataset.status;

            if (!status || status.toLowerCase() === 'all') {
                currentOrder.style.display = 'block'; // Show all orders if status is empty or 'all'
                anyOrdersDisplayed = true;
            } else if (orderStatus === status.toLowerCase()) {
                currentOrder.style.display = 'block'; // Show orders with the selected status
                anyOrdersDisplayed = true;
            } else {
                currentOrder.style.display = 'none'; // Hide orders that don't match the selected status
            }
        });

        if (!anyOrdersDisplayed && !noOrdersMessageShown) {
            // If no orders were displayed and the message hasn't been shown yet, display the message
            let messageContainer = document.createElement('div');
            messageContainer.innerText = 'No orders to display for this status.';
            document.body.appendChild(messageContainer); // Append the message to the body or a suitable container
            noOrdersMessageShown = true; // Set the flag to true to indicate that the message has been shown
        }
    }
</script>