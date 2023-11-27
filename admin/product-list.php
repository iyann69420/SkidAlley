<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Product List</h1>

        <br/><br/>

        <?php
        if (isset($_SESSION['add'])) 
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if(isset($_SESSION['delete']))
        {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        if(isset($_SESSION['unauthorize']))
        {
            echo $_SESSION['unauthorize'];
            unset($_SESSION['unauthorize']);
        }
        if(isset($_SESSION['update']))
        {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        
        ?>
        <br><br>
        <a href="<?php echo SITEURL; ?>admin/add-product-list.php" class="btn-primary">Add Product</a>
        <br/><br/><br/>

        <table class="tbl-full">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Price</th>
                <th>Description</th>
                <th>Image</th>
                <th>Category</th>
                <th>Brands</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php
            $sql = "SELECT * FROM product_list";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            $sn = 1;

            if ($count > 0) 
            {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $id = $row['id'];
                    $title = $row['name'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_path'];
                    $category_id = $row['category_id'];
                    $brand_id = $row['brand_id'];
                    $status = $row['status'];
                    $status_display = ($status == 1) ? "Active" : "Inactive";

                    // Fetch the category name based on the category_id from the categories table
                    $category_query = "SELECT category FROM categories WHERE id = $category_id";
                    $category_result = mysqli_query($conn, $category_query);
                    if ($category_result && mysqli_num_rows($category_result) > 0) {
                        $category_row = mysqli_fetch_assoc($category_result);
                        $category_name = $category_row['category'];
                    } else {
                        $category_name = "Category not found";
                    }

                    $brand_query = "SELECT name FROM brand_list WHERE id = $brand_id";
                    $brand_result = mysqli_query($conn, $brand_query);
                    if ($brand_result && mysqli_num_rows($brand_result) > 0) {
                        $brand_row = mysqli_fetch_assoc($brand_result);
                        $brand_name = $brand_row['name'];
                    } else {
                        $brand_name = "Brand not found";
                    }


                    ?>

                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>
                        <td>₱<?php echo number_format($price); ?></td>
                        <td><?php echo $description; ?></td>
                        <td>
                            <?php
                            if ($image_name == "") 
                            {
                                echo "<div class='error'>Image not Added.</div>";
                            } else {
                                ?>
                                <img src="<?php echo SITEURL; ?>images/bike/<?php echo $image_name; ?>"
                                     width="100px">
                                <?php
                            }
                            ?>
                        </td>
                        <td><?php echo $category_name; ?></td>
                        <td><?php echo $brand_name; ?></td>
                        <td style='color: <?php echo ($status == 1) ? "green" : "red"; ?>;'><?php echo $status_display; ?></td>
                        <td>
                                <a href="<?php echo SITEURL; ?>admin/update-product-list.php?id=<?php echo $id; ?>" class='btn-secondary'>Update Product</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-product-list.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name;?>" class="btn-third">Delete Product</a>
                        </td>
                    </tr>

                    <?php
                }
            } 
            else 
            {
                echo "<tr> <td colspan='9' class='error'> Product not added yet. </td>  </tr>";
            }
            ?>
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
