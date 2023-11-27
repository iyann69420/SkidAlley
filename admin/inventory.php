<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Inventory</h1>

        <br/><br/>
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
        if(isset($_SESSION['update']))
        {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>
        <br/><br/>
        <a href="<?php echo SITEURL; ?>admin/add-inventory.php" class="btn-primary">Add Inventory</a>
        <br/><br/><br/>

        <table class="tbl-full">
    <tr>
        <th>#</th>
        <th>Product</th>
        <th>Image</th>
        <th>Brand</th>
        <th>Color</th>
        <th>Size</th>
        <th>Quantity</th>
        <th>Action</th>
    </tr>
    <?php
  $sql = "SELECT sl.id, sl.quantity, sl.product_id, pcs.color AS product_color, pcs.size AS product_size
  FROM stock_list sl
  INNER JOIN product_colors_sizes pcs ON sl.product_colors_sizes_id = pcs.id
  ORDER BY pcs.color ASC";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    $sn = 1;

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $id = $row['id'];
            $quantity = $row['quantity'];
            $product_id = $row['product_id'];
            $product_color = $row['product_color'];
            $product_size = $row['product_size'];

            // Fetch product name, brand name, and image path
            $product_sql = "SELECT p.name AS product_name, p.image_path AS product_image, b.name AS brand_name
                            FROM product_list p
                            INNER JOIN brand_list b ON p.brand_id = b.id
                            WHERE p.id = $product_id";
            $product_result = mysqli_query($conn, $product_sql);
            if ($product_result && mysqli_num_rows($product_result) > 0) {
                $product_row = mysqli_fetch_assoc($product_result);
                $product_name = $product_row['product_name'];
                $brand_name = $product_row['brand_name'];
                $product_image = $product_row['product_image'];
            } else {
                $product_name = "<div class='error'>Product Not Found</div>";
                $brand_name = "<div class='error'>Brand Not Found</div>";
                $product_image = ""; // Set an empty image path if not found
            }

            ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $product_name;?></td>
                <td>
                <?php
                    if (!empty($product_image)) {
                        echo "<img src='" . SITEURL . "images/bike/" . $product_image . "' width='50px' alt='Product Image'> ";
                    }
                    else{
                        
                    }
                   
                    ?>
                </td>
                <td><?php echo $brand_name ?></td>
                <td><?php echo $product_color ?></td> 
                <td><?php echo $product_size ?></td>
                <td><?php echo $quantity ?></td>
                <td>
                    <a href="<?php echo SITEURL; ?>admin/update-inventory.php?id=<?php echo $id; ?>" class='btn-secondary'>Update Inventory</a>
                    <a href="<?php echo SITEURL; ?>admin/delete-inventory.php?id=<?php echo $id; ?>" class="btn-third">Delete Inventory</a>
                </td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <td colspan='4'><div class='error'>No Brand Added.</div></td>
        </tr>
        <?php
    }
    ?>
</table>

    </div>
</div>
<?php include('partials/footer.php') ?>
