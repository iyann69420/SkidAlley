<?php include('partials/menu.php'); ?>

<style>
    
     .print-button, .filter-button {
        background-color: black;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
    }

    .print-button:hover, .filter-button:hover {
        background-color: orange;
    }
</style>

<div class="main-content">
    <div class="wrapper">
        <h1>Sales Report</h1>

        <br /><br />
        <button onclick="printSalesReport()" class="print-button">Print / Save as PDF</button>
        <br><br>


        <div class="filter">

        
            <form method="post" action="">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date">

                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date">

                <input type="submit" value="Filter" class="filter-button">
            </form>
        </div>

        <table class="tbl-full">
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 15%;">Date Created</th>
                <th style="width: 20%;">Product Name</th>
                <th style="width: 15%;">Color/Size</th>
                <th style="width: 10%;">Quantity</th>
                <th style="width: 15%;">Total Amount</th>
            </tr>

            <?php
            // Check if the form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get start and end dates from the form
                $start_date = $_POST["start_date"];
                $end_date = $_POST["end_date"];

                // Modify the SQL query to include date filtering
                $sql = "SELECT ol.id, ol.ref_code, pl.name AS product_name, op.color, op.size, op.quantity, ol.total_amount, ol.delivery_address, ol.payment_method, ol.date_created
                        FROM order_list ol
                        JOIN order_products op ON ol.id = op.order_id
                        JOIN product_list pl ON op.product_id = pl.id
                        WHERE ol.order_receive = 1 AND ol.date_created BETWEEN '$start_date' AND '$end_date'";
            } else {
                // Default query without date filtering
                $sql = "SELECT ol.id, ol.ref_code, pl.name AS product_name, op.color, op.size, op.quantity, ol.total_amount, ol.delivery_address, ol.payment_method, ol.date_created
                        FROM order_list ol
                        JOIN order_products op ON ol.id = op.order_id
                        JOIN product_list pl ON op.product_id = pl.id
                        WHERE ol.order_receive = 1";
            }

            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            $sn = 1;
            $grandTotal = 0;

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $dateCreated = $row['date_created'];
                    $refCode = $row['ref_code'];
                    $product_name = $row['product_name'];
                    $color = $row['color'];
                    $size = $row['size'];
                    $quantity = $row['quantity'];
                    $totalAmount = $row['total_amount'];
                    $deliveryAddress = $row['delivery_address'];
                    $paymentMethod = $row['payment_method'];

                    // Update the grand total
                    $grandTotal += $totalAmount;

                    
                    ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $dateCreated; ?></td>
                        <td><?php echo $product_name; ?></td>
                        <td><?php echo $color . '/' . $size; ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td><?php echo number_format($totalAmount); ?></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan='8'><div class='error'>No Sales Added.</div></td>
                </tr>
                <?php
            }
            ?>

            <?php if ($count > 0) : ?>
                <tr>
                    <td colspan="5" style="text-align: right; font-weight: bold;">Grand Total:</td>
                    <td><?php echo number_format($grandTotal); ?></td>
                </tr>
            <?php endif; ?>

        </table>
    </div>
</div>

<script>
    function printSalesReport() {
        // Clone the table element
        var tableToPrint = document.querySelector('.tbl-full').cloneNode(true);

        // Create a new window for the print preview
        var printWindow = window.open('', '_blank');
        printWindow.document.open();

        // Append the cloned table to the new window with additional CSS and logo
        printWindow.document.write(`
            <html>
                <head>
                    <title>Skid Alley Sales Report</title>
                    <style>
                        /* Add custom CSS for printing */
                        body {
                            font-family: Arial, sans-serif;
                        }
                        table {
                            border-collapse: collapse;
                            width: 100%;
                        }
                        th, td {
                            border: 1px solid black; /* Add border or customize as needed */
                            padding: 8px;
                            text-align: left;
                        }
                        .title-container {
                            display: flex;
                            align-items: center;
                            
                            margin-bottom: 10px;
                        }
                        .title {
                            font-size: 32px;
                            font-weight: bold;
                        }
                        .logo {
                            max-height: 100px; /* Set the max height of the logo */
                        }
                    </style>
                </head>
                <body>
                    <div class="title-container">
                        <img class="logo" src="/SkidAlley/images/logo.png" alt="Logo">
                        <div class="title">Skid Alley Sales Report</div>
                    </div>
                    ${tableToPrint.outerHTML}
                </body>
            </html>
        `);

        printWindow.document.close();

        // Trigger the print function in the new window
        printWindow.print();
    }
</script>


<?php include('partials/footer.php'); ?>
