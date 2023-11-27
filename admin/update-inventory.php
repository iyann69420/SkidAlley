<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Inventory</h1>
        <br><br>

        <?php
        // Your database connection code here

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $sql = "SELECT s.product_id, s.quantity, p.name AS product_name 
                    FROM stock_list s
                    INNER JOIN product_list p ON s.product_id = p.id
                    WHERE s.id = $id";

            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);
                $product_id = $row['product_id'];
                $product_name = $row['product_name'];
                $quantity = $row['quantity'];
            } else {
                $_SESSION['no-category-found'] = "<div class='error'>Inventory not found</div>";
                header('location:' . SITEURL . 'admin/inventory.php');
                exit();
            }
        } else {
            header('location:' . SITEURL . 'admin/inventory.php');
            exit();
        }
        ?>

        <br><br>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Product Name: </td>
                    <td>
                        <!-- Display the selected product name -->
                        <input type="text" name="product" value="<?php echo $product_name; ?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td>Current Quantity:</td>
                    <td>
                        <input type="number" value="<?php echo $quantity; ?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td>Change Quantity:</td>
                    <td>
                        <!-- Allow the user to add or subtract from the current quantity -->
                        <input type="number" name="change_quantity" value="" step="any">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Update Stocks" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

    </div>
</div>

<?php include('partials/footer.php') ?>

<?php
if (isset($_POST['submit'])) {
    $change_quantity = $_POST['change_quantity'];

    // Calculate the new quantity based on the change
    $new_quantity = $quantity + $change_quantity;

    // Update the quantity in the database
    $update_sql = "UPDATE stock_list SET quantity = $new_quantity WHERE id = $id";
    $update_res = mysqli_query($conn, $update_sql);

    if ($update_res) {
        $_SESSION['update'] = "<div class ='success'>Inventory Updated Successfully.</div>";
        header('location:' . SITEURL . 'admin/inventory.php');
        exit();
    } else {
        $_SESSION['update'] = "<div class ='error'>Failed to Update Inventory.</div>";
        header('location:' . SITEURL . 'admin/inventory.php');
        exit();
    }
}
?>
