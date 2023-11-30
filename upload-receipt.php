<?php
include ('./config/constants.php');

if (isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];

    $orderDetailsQuery = "SELECT ref_code, payment_method FROM order_list WHERE id = $orderId";
    $orderDetailsResult = mysqli_query($conn, $orderDetailsQuery);

    if ($orderDetailsResult) {
        $orderDetails = mysqli_fetch_assoc($orderDetailsResult);

        if ($orderDetails) {
            $refCode = $orderDetails['ref_code'];
            $paymentMethod = $orderDetails['payment_method'];
            

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Handle file upload and database update
                $uploadDir = 'C:/xampp/htdocs/SkidAlley/images/gcash_receipts/';
                $uploadFile = $uploadDir . basename($_FILES['receipt_file']['name']);

                // Check if the file with the same name already exists in gcash_receipts
                $checkExistingFileQuery = "SELECT id FROM gcash_receipts WHERE file_name = '" . basename($_FILES['receipt_file']['name']) . "' LIMIT 1";
                $checkExistingFileResult = mysqli_query($conn, $checkExistingFileQuery);

                if ($checkExistingFileResult && mysqli_num_rows($checkExistingFileResult) > 0) {
                    echo"File with the same name already exists in gcash_receipts."; 
                    $_SESSION['failed'] = true;
                    header("Location: orderstatus.php");
                    exit(); 
                } else {
                    if (move_uploaded_file($_FILES['receipt_file']['tmp_name'], $uploadFile)) {
                        // File uploaded successfully, update the database and send admin notification

                        // Update gcash_receipts table
                        $fileName = basename($_FILES['receipt_file']['name']);
                        $filePath = 'images/gcash_receipts/' . $fileName;

                        $insertReceiptQuery = "INSERT INTO gcash_receipts (file_name, file_path, upload_timestamp) VALUES ('$fileName', '$filePath', NOW())";
                        mysqli_query($conn, $insertReceiptQuery);

                        // Get the last inserted gcash_receipts_id
                        $gcashReceiptsId = mysqli_insert_id($conn);

                        // Fetch order_products_id based on the order_id
                        $getOrderProductsIdQuery = "SELECT id FROM order_products WHERE order_id = $orderId LIMIT 1";
                        $getOrderProductsIdResult = mysqli_query($conn, $getOrderProductsIdQuery);

                        if ($getOrderProductsIdResult && $orderProductsRow = mysqli_fetch_assoc($getOrderProductsIdResult)) {
                            $orderProductsId = $orderProductsRow['id'];

                            // Update admin_notifications table
                            $notificationType = 'Receipt Uploaded';
                            $isApproved = 3; 

                            $insertNotificationQuery = "INSERT INTO admin_notifications (order_id, order_products_id, notification_type, is_approved, gcash_receipts_id) VALUES ($orderId, $orderProductsId, '$notificationType', $isApproved, $gcashReceiptsId)";
                            mysqli_query($conn, $insertNotificationQuery);

                            $updateOrderQuery = "UPDATE order_list SET gcash_receipts_id = $gcashReceiptsId WHERE id = $orderId";
                            mysqli_query($conn, $updateOrderQuery);

                            echo "Receipt uploaded successfully for order ID $orderId (Ref Code: $refCode) via $paymentMethod";
                            
                            $_SESSION['gcashReceiptUploaded'] = true;
                            header("Location: orderstatus.php");
                            exit();
                        } else {
                            echo "Error fetching order_products_id: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Error uploading file.";
                    }
                }
            } else {
                //
                ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/themes/default.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>
    <title>Upload Receipt</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }

        .upload-form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
        }

        h2 {
            color: black;
        }

        .column {
            display: flex;
            flex-direction: column;
            text-align: left;
            margin: 15px 0;
        }

        .column p {
            margin: 5px 0;
        }

        strong {
            color: black; /* Orange color */
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #ff8c00; /* Dark orange color on hover */
        }

        input[type="file"] {
            margin-top: 10px;
        }

        #preview {
            margin: 20px 0; /* Add margin to the preview container */
        }
    </style>
    </head>
    <body>
    <div class="upload-form">
        <h2>Upload Receipt for Order ID <?php echo $orderId; ?></h2>

        <div class="column">
            <p>Ref Code: <strong><?php echo $refCode; ?></strong></p>
        </div>

        <div class="column">
            <p>Payment Method: <strong><?php echo $paymentMethod; ?></strong></p>
        </div>

        <div class="column">
            <p>G Cash Name: <strong>Skid Alley</strong></p>
        </div>

        <div class="column">
            <p>Number: <strong>01201021020</strong></p>
        </div>

        <form action="upload-receipt.php?order_id=<?php echo $orderId; ?>" method="post" enctype="multipart/form-data">
            <!-- Add your existing form fields here -->

            <label for="receipt_file">Upload Receipt:</label>
            <input type="file" name="receipt_file" id="receipt_file" required onchange="previewImage()">
            <br>
            <div id="preview"></div> <!-- Move the preview container here -->
            <button type="submit" name="submit">Submit</button>
        </form>

        <script>
        function previewImage() {
            var input = document.getElementById('receipt_file');
            var preview = document.getElementById('preview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '100px';
                    preview.innerHTML = '';
                    preview.appendChild(img);
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.innerHTML = '';
            }
        }
        </script>
    </div>
    </body>
    </html>
                <?php
            }
        } else {
            echo "Order not found";
        }
    } else {
        echo "Error fetching order details: " . mysqli_error($conn);
    }
} else {
    echo "Order ID not provided";
}
?>
