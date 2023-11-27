<?php
    include('../config/constants.php');

    $id = $_GET['id'];

    // Retrieve the brand IDs associated with the category
    $get_brand_ids_sql = "SELECT brand_id FROM category_brands WHERE category_id=$id";
    $get_brand_ids_result = mysqli_query($conn, $get_brand_ids_sql);

    $brand_ids = [];

    // Fetch the brand IDs
    while ($row = mysqli_fetch_assoc($get_brand_ids_result)) {
        $brand_ids[] = $row['brand_id'];
    }

    // Delete associated records in the category_brands table
    $delete_category_brands_sql = "DELETE FROM category_brands WHERE category_id=$id";
    $delete_category_brands_result = mysqli_query($conn, $delete_category_brands_sql);

    // If deletion is successful, proceed with deleting the associated records in the brand_list table
    if ($delete_category_brands_result) {
        foreach ($brand_ids as $brand_id) {
            $delete_brand_list_sql = "DELETE FROM brand_list WHERE id=$brand_id";
            $delete_brand_list_result = mysqli_query($conn, $delete_brand_list_sql);
            if (!$delete_brand_list_result) {
                // Handle the error, if any
                $_SESSION['delete'] = "<div class='error'>Failed to Delete Brand with ID: $brand_id</div>";
                header('location:' . SITEURL . 'admin/categories.php');
                exit();
            }
        }

        // Delete the category after deleting associated brands
        $delete_category_sql = "DELETE FROM categories WHERE id=$id";
        $delete_category_result = mysqli_query($conn, $delete_category_sql);

        // Check whether the category and associated brands are deleted successfully
        if ($delete_category_result) {
            $_SESSION['delete'] = "<div class='success'>Category and Associated Brands Deleted Successfully</div>";
            header('location:' . SITEURL . 'admin/categories.php');
        } else {
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Category</div>";
            header('location:' . SITEURL . 'admin/categories.php');
        }
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Category and Associated Brands</div>";
        header('location:' . SITEURL . 'admin/categories.php');
    }
?>
