<?php include('partials/menu.php'); ?>
 
<div class="main-content">
    <div class="wrapper">
        <h1>Add Categories</h1>

        <br><br>

        <?php
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        ?>
        <br><br>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Category Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Brand Names (separated by comma):</td>
                    <td>
                        <input type="text" name="brands" placeholder="Brand Name1, Brand Name2, Brand Name3">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

       
        <?php
        if (isset($_POST['submit'])) {
            $title = $_POST['title'];
            $description = ''; // Initialize $description if needed
            $brandsInput = $_POST['brands']; // Get the input string of brands
            $brands = array_map('trim', explode(',', $brandsInput)); // Convert the input string to an array

            if (empty($title)) {
                echo "<div class='error'>Please input a category title.</div>";
            } else {
                // Set the status to "Active" (Yes) by default
                $status = 1;

                // Insert the new category into the categories table
                $insert_category_sql = "INSERT INTO categories (category, description, status, delete_flag) VALUES ('$title', '$description', '$status', '0')";
                $insert_category_result = mysqli_query($conn, $insert_category_sql);

                if ($insert_category_result) {
                    $category_id = mysqli_insert_id($conn);

                    // Insert the brands into the brand_list table
                    foreach ($brands as $brand) {
                        $insert_brand_sql = "INSERT INTO brand_list (name, image_path, delete_flag, status) VALUES ('$brand', 'path_to_image', '0', '1')";
                        $insert_brand_result = mysqli_query($conn, $insert_brand_sql);

                        if ($insert_brand_result) {
                            $brand_id = mysqli_insert_id($conn);

                            // Insert category and brand relationships into the category_brands table
                            $insert_category_brand_sql = "INSERT INTO category_brands (category_id, brand_id) VALUES ('$category_id', '$brand_id')";
                            $insert_category_brand_result = mysqli_query($conn, $insert_category_brand_sql);

                            if (!$insert_category_brand_result) {
                                // Handle the error as per your application's requirements
                                // You might want to log the error or show an error message to the user
                            }
                        } else {
                            // Handle the error for brand insertion
                        }
                    }

                    // Redirect to the appropriate page after successful insertion
                    header('location: '.SITEURL.'admin/categories.php');
                } else {
                    $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
                    header('location: '.SITEURL.'admin/add-categories.php');
                }
            }
        }
        ?>
        
    </div>
</div>

<?php include('partials/footer.php'); ?>
