<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Colors and Sizes</h1>

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
        <a href="<?php echo SITEURL; ?>admin/add-colors-sizes.php" class="btn-primary">Add Colors And Sizes</a>
        <br/><br/><br/>

        <table class="tbl-full">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Product Name</th>
                <th>Color</th>
                <th>Size</th>
                <th>Action</th>
            </tr>
            <?php
            $sql = "SELECT * FROM product_colors_sizes";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            $sn = 1;

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $color = $row['color'];
                    $size = $row['size'];
                    $product_id = $row['product_id'];

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
                        $product_name = "Product Not Found";
                        $brand_name = "Brand Not Found";
                        $product_image = ""; // Set an empty image path if not found
                    }

                    ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                      
                        <td>
                            <?php
                            if (!empty($product_image)) {
                                echo "<img src='" . SITEURL . "images/bike/" . $product_image . "' width='50px' alt='Product Image'> ";
                            }
                            ?>
                        </td>
                        <td><?php echo $product_name; ?></td>
                        <td><?php echo $color; ?></td>
                        <td><?php echo $size; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-colors-sizes.php?id=<?php echo $id; ?>" class='btn-secondary'>Update </a>
                            <a href="<?php echo SITEURL; ?>admin/delete-colors-sizes.php?id=<?php echo $id; ?>" class="btn-third">Delete </a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan='6'><div class='error'>No Colors and Sizes Added.</div></td>
                </tr>
                <?php
            }
            ?>
        </table>

    </div>
</div>
<?php include('partials/footer.php') ?>
