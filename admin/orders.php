<?php include('partials/menu.php'); ?>


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

        <table class="tbl-full">
            <tr>
                <th>#</th>
                <th>Date Ordered</th>
                <th>Ref. Code</th>
                <th>Client ID</th>
                <th>Delivery Address</th>
                <th>Total Amount</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php
            $sql = "SELECT * FROM order_list";
            $res = mysqli_query($conn, $sql);

            if ($res == TRUE) {
                $count = mysqli_num_rows($res);

                $sn = 1;

                if ($count > 0) {
                    while ($rows = mysqli_fetch_assoc($res)) {
                        $id = $rows['id'];
                        $ref_code = $rows['ref_code'];
                        $client_id = $rows['client_id'];
                        $total_amount = $rows['total_amount'];
                        $deliveryAddress = $rows['delivery_address'];
                        $paymentMethod = $rows['payment_method'];
                        $status = $rows['status'];
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
                        $statusLabel = isset($statusLabels[$status]) ? $statusLabels[$status] : 'Unknown';

                        ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $date_ordered; ?></td>
                            <td><?php echo $ref_code; ?></td>
                            <td><?php echo $client_id; ?></td>
                            <td><?php echo $deliveryAddress; ?></td>
                            <td>₱<?php echo $total_amount; ?></td>
                            <td><?php echo $paymentMethod ?></td>
                            <td class="status-label <?php echo strtolower(str_replace(' ', '-', $statusLabel)); ?>"><?php echo $statusLabel; ?></td>

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
</div>

<?php include('partials/footer.php'); ?>
