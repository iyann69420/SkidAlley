<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Categories</h1>

        <br /><br />

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
        if(isset($_SESSION['no-category-found']))
        {
            echo $_SESSION['no-category-found'];
            unset($_SESSION['no-category-found']);
        }
        if(isset($_SESSION['update']))
        {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>
        <br><br>

        <a href="<?php echo SITEURL; ?>admin/add-categories.php" class="btn-primary">Add Categories</a>
        <br /><br /><br />

        <table class="tbl-full">
        <tr>
            <th>#</th>
            <th>Category Name</th>
            <th>Brands</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php
        $sql = "SELECT * FROM categories";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
        $sn = 1;

        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $title = $row['category'];
                $status = $row['status'];
                $status_display = ($status == 1) ? "Active" : "Inactive";
                ?>

                <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $title; ?></td>
                    <td>
                        <?php
                        // Fetch brands for the current category
                        $brands_query = "SELECT bl.name FROM brand_list bl
                                         JOIN category_brands cb ON bl.id = cb.brand_id
                                         WHERE cb.category_id = $id";
                        $brands_result = mysqli_query($conn, $brands_query);

                        if (mysqli_num_rows($brands_result) > 0) {
                            $brand_names = array();
                            while ($brand_row = mysqli_fetch_assoc($brands_result)) {
                                $brand_names[] = $brand_row['name'];
                            }
                            echo implode(", ", $brand_names);
                        } else {
                            echo "No Brands Available";
                        }
                        ?>
                    </td>
                    <td style='color: <?php echo ($status == 1) ? "green" : "red"; ?>;'><?php echo $status_display; ?></td>
                    <td>
                        <a href="<?php echo SITEURL; ?>admin/update-categories.php?id=<?php echo $id; ?>" class='btn-secondary'>Update Category</a>
                        <a href="<?php echo SITEURL; ?>admin/delete-categories.php?id=<?php echo $id; ?>" class="btn-third">Delete Category</a>
                    </td>
                </tr>

            <?php
            }
        } else {
            ?>
            <tr>
                <td colspan='4'><div class='error'>No Category Added.</div></td>
            </tr>
            <?php
        }
        ?>

    </table>
</div>
</div>

<?php include('partials/footer.php'); ?>
