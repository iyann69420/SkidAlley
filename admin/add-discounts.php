<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Discounts </h1>
        <?php
       
        ?>

        <br><br>

        <form action="" method="POST">

            <table class="tbl-30">
            <tr>
                    <td>Product</td>
                    <td>
                        <select name="product">
                        <?php
                           

                     
                            $sql = "SELECT id, name FROM product_list WHERE delete_flag = 0";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No products found</option>";
                            }

                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Product Image</td>
                    <td colspan="2">
                        <img id="productImage" src="" alt="Product Image" width="100">
                    </td>
                </tr>
                <tr>
                <td>Discount Percentage:</td>
                    <td>
                        <input type="number" name="discount_percentage" min="0" max="100" step="0.01" placeholder="Enter discount percentage">
                    </td>
                </tr>

                <tr>
                    <td>Start Time:</td>
                    <td>
                        <input type="date" name="start_time" placeholder="Enter start time">
                    </td>
                </tr>
                <tr>
                    <td>End Time:</td>
                    <td>
                        <input type="date" name="end_time" placeholder="Enter end time">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Discount" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>



<?php include('partials/footer.php') ?>

