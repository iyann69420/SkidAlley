    <?php include('partials/menu.php'); ?>

    <style>
        #order-table th a {
            color: inherit; /* Use the default color for links */
            text-decoration: none; /* Remove underlining */
            display: inline-block;
        }

        #order-table th a i {
            margin-left: 5px; /* Adjust the icon's position */
        }

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
            <h1>Order List</h1>

            <br/>

            <?php
            if (isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
            ?>
            <br/><br/><br/>

            <div class="filter">
                <form method="post" action="">
                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" name="start_date">

                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" name="end_date">

                    <input type="submit" value="Filter" class="filter-button">
                </form>
            </div>

            <table class="tbl-full" id="order-table">
                <tr>
                    <th>#</th>
                    <th><a href="javascript:void(0);" id="sort-date"><i class="fas fa-sort"></i> Date Ordered</a></th>
                    <th>Ref. Code</th>
                    <th>Client Name</th>
                    <th>Delivery Address</th>
                    <th>Total Amount</th>
                    <th>Payment Method</th>
                    <th><a href="javascript:void(0);" id="sort-status"><i class="fas fa-sort"></i> Status</a></th>
                    <th>Action</th>
                </tr>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Get start and end dates from the form
                    $start_date = $_POST["start_date"];
                    $end_date = $_POST["end_date"];
                
                    // Modify the SQL query to include date filtering
                    $sql = "SELECT ol.*, cl.fullname AS client_name FROM order_list ol
                            INNER JOIN client_list cl ON ol.client_id = cl.id
                            WHERE ol.date_created BETWEEN '$start_date' AND '$end_date'";
                } else {
                    $sql = "SELECT ol.*, cl.fullname AS client_name FROM order_list ol
                            INNER JOIN client_list cl ON ol.client_id = cl.id";
                }
                
                $res = mysqli_query($conn, $sql);
        

                if ($res == TRUE) {
                    $count = mysqli_num_rows($res);

                    $sn = 1;

                    if ($count > 0) {
                        while ($rows = mysqli_fetch_assoc($res)) {
                            $id = $rows['id'];
                            $ref_code = $rows['ref_code'];
                            $client_id = $rows['client_id'];
                            $client_name = $rows['client_name']; // Change to client_name
                            $total_amount = $rows['total_amount'];
                            $deliveryAddress = $rows['delivery_address'];
                            $paymentMethod = $rows['payment_method'];
                            $status = $rows['status'];
                            $order_receive = $rows['order_receive'];
                            $date_ordered = $rows['date_created'];

                            // Define status labels based on the status values
                            $statusLabels = array(
                                0 => 'Pending',
                                1 => 'Packed',
                                2 => 'For Delivery',
                                3 => 'On the Way',
                                4 => 'Delivered',
                                5 => 'Cancelled'
                            );

                            // Modify the status label based on order_received
                            if ($order_receive == 1) {
                                $statusLabel = 'Delivered (Received)';
                                $statusCellStyle = 'background-color: #00cc66; color: #fff;'; // CSS styling
                            } else {
                                $statusLabel = isset($statusLabels[$status]) ? $statusLabels[$status] : 'Unknown';
                                $statusCellStyle = ''; // No additional styling
                            }
                            ?>

                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo date('F j, Y g:i A', strtotime($date_ordered)); ?></td>
                                <td><?php echo $ref_code; ?></td>
                                <td><?php echo $client_name; ?></td>
                                <td><?php echo $deliveryAddress; ?></td>
                                <td>₱<?php echo number_format($total_amount); ?></td>
                                <td><?php echo $paymentMethod ?></td>
                                <td style="<?php echo $statusCellStyle; ?>" class="status-label <?php echo strtolower(str_replace(' ', '-', $statusLabel)); ?>"><?php echo $statusLabel; ?></td>

                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-orders.php?id=<?php echo $id; ?>" class="btn-secondary">View Order</a>
                                    <a href="<?php echo SITEURL; ?>admin/delete-orders.php?id=<?php echo $id; ?>" class="btn-third">Delete</a>
                                </td>
                            </tr>

                            <?php
                        }
                    } else {
                        // Display a message when there are no orders
                        echo "<td colspan='7'><div class='error'>No Orders Found.</div></td>";
                    }
                }
                ?>
            </table>
        </div>
        <br><br><br>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script>
        $(document).ready(function () {
            // Variables to track current sorting order
            var dateOrderAsc = true;
            var statusAsc = true;

            // Sort by Date Ordered
            $('#sort-date').click(function () {
                sortTable("order-table", 1, dateOrderAsc);
                dateOrderAsc = !dateOrderAsc; // Toggle sorting order
            });

            // Sort by Status
            $('#sort-status').click(function () {
                sortTable("order-table", 7, statusAsc);
                statusAsc = !statusAsc; // Toggle sorting order
            });

            // Function to sort the table
            function sortTable(tableId, columnIndex, ascending) {
                var table, rows, switching, i, x, y, shouldSwitch;
                table = document.getElementById(tableId);
                switching = true;

                while (switching) {
                    switching = false;
                    rows = table.rows;

                    for (i = 1; i < (rows.length - 1); i++) {
                        shouldSwitch = false;
                        x = rows[i].getElementsByTagName("td")[columnIndex];
                        y = rows[i + 1].getElementsByTagName("td")[columnIndex];

                        // Compare based on data type (Date or String)
                        if (columnIndex === 1) {
                            if ((ascending ? new Date(x.innerHTML) : new Date(y.innerHTML)) > (ascending ? new Date(y.innerHTML) : new Date(x.innerHTML))) {
                                shouldSwitch = true;
                                break;
                            }
                        } else {
                            if ((ascending ? x.innerHTML.toLowerCase() : y.innerHTML.toLowerCase()) > (ascending ? y.innerHTML.toLowerCase() : x.innerHTML.toLowerCase())) {
                                shouldSwitch = true;
                                break;
                            }
                        }
                    }

                    if (shouldSwitch) {
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                    }
                }
            }
        });
    </script>

    <?php include('partials/footer.php'); ?>
