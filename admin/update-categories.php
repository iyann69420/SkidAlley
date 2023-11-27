<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Categories</h1>
        <br><br>

        <?php
        if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }

        $id = $_GET['id'];

        $sql = "SELECT * FROM categories WHERE id = $id";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            $row = mysqli_fetch_assoc($res);
            $title = $row['category'];
            $status = $row['status'];
        } else {
            $_SESSION['no-category-found'] = "<div class='error'>Category not found</div>";
            header('location:' . SITEURL . 'admin/categories.php');
            exit();
        }

        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $status = isset($_POST['status']) ? $_POST['status'] : 'No';
            $brands = isset($_POST['brands']) ? $_POST['brands'] : '';

            if (empty($title)) {
                $_SESSION['error'] = "<div class='error'>Please input a title.</div>";
                header('location: ' . SITEURL . 'admin/update-categories.php?id=' . $id);
                exit();
            }

            $sql2 = "UPDATE categories SET
                    category = '$title',
                    status = '$status'
                    WHERE id=$id";

            $res2 = mysqli_query($conn, $sql2);

            if ($res2) {
                if (!empty($brands)) {
                    $brandArray = array_map('trim', explode(',', $brands));

                    // Clear existing entries in the category_brands table for this category
                    $delete_category_brands_sql = "DELETE FROM category_brands WHERE category_id=$id";
                    $delete_category_brands_result = mysqli_query($conn, $delete_category_brands_sql);

                    foreach ($brandArray as $brand) {
                        // Check if the brand already exists in the brand_list table
                        $check_brand_sql = "SELECT * FROM brand_list WHERE name='$brand'";
                        $check_brand_result = mysqli_query($conn, $check_brand_sql);

                        if (mysqli_num_rows($check_brand_result) == 0) {
                            // Brand doesn't exist, so add it to brand_list
                            $insert_brand_sql = "INSERT INTO brand_list (name, image_path, delete_flag, status) 
                            VALUES ('$brand', 'path_to_image', '0', '1')";
                            $insert_brand_result = mysqli_query($conn, $insert_brand_sql);

                            if ($insert_brand_result) {
                                $brand_id = mysqli_insert_id($conn);

                                // Insert the category and brand relationship into the category_brands table
                                $insert_category_brand_sql = "INSERT INTO category_brands (category_id, brand_id) 
                                VALUES ('$id', '$brand_id')";
                                $insert_category_brand_result = mysqli_query($conn, $insert_category_brand_sql);

                                if (!$insert_category_brand_result) {
                                    $_SESSION['error'] = "<div class='error'>Failed to associate brand with category.</div>";
                                    header('location: ' . SITEURL . 'admin/update-categories.php?id=' . $id);
                                    exit();
                                }
                            } else {
                                $_SESSION['error'] = "<div class='error'>Failed to add new brand.</div>";
                                header('location: ' . SITEURL . 'admin/update-categories.php?id=' . $id);
                                exit();
                            }
                        } else {
                            $brand_row = mysqli_fetch_assoc($check_brand_result);
                            $brand_id = $brand_row['id'];

                            // Insert the category and brand relationship into the category_brands table
                            $insert_category_brand_sql = "INSERT INTO category_brands (category_id, brand_id) 
                            VALUES ('$id', '$brand_id')";
                            $insert_category_brand_result = mysqli_query($conn, $insert_category_brand_sql);

                            if (!$insert_category_brand_result) {
                                $_SESSION['error'] = "<div class='error'>Failed to associate brand with category.</div>";
                                header('location: ' . SITEURL . 'admin/update-categories.php?id=' . $id);
                                exit();
                            }
                        }
                    }
                }

                $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                header('location: ' . SITEURL . 'admin/categories.php');
                exit();
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
                header('location: ' . SITEURL . 'admin/categories.php');
                exit();
            }
        }
        ?>

        <br><br>

        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <table class="tbl-30">
                <tr>
                    <td>Category Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Brand Names (separated by comma):</td>
                    <td>
                        <input type="text" name="brands" placeholder="Brand Name1, Brand Name2, Brand Name3">
                    </td>
                </tr>

                <tr>
                    <td>Status:</td>
                    <td>
                        <input <?php if ($status == 1) {
                            echo "checked";
                        } ?> type="radio" name="status" value="1"> Active
                        <input <?php if ($status == 0) {
                            echo "checked";
                        } ?> type="radio" name="status" value="0"> Inactive
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>
