<?php include('partials/menu.php'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 
<div class="main-content">
    <div class ="wrapper">
        <h1>Add Product</h1>

        <br><br>

        <?php
          if(isset($_SESSION['upload']))
          {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
          }
          if(isset($_SESSION['error']))
          {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
          }
        ?>


        <form action="" method="POST" enctype="multipart/form-data">

        <table class ="tbl-30">
        <tr>
            <td>Category: </td>
            <td>
                    <select name="category_id" id="category_id">
                    <?php
                    $sql = "SELECT DISTINCT category_id FROM category_brands";
                    $res = mysqli_query($conn, $sql);

                    $count = mysqli_num_rows($res);

                    if ($count > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $category_id = $row['category_id'];
                            // Assuming you have a 'categories' table to fetch the category names
                            $category_sql = "SELECT * FROM categories WHERE id='$category_id' AND status='1'";
                            $category_res = mysqli_query($conn, $category_sql);
                            $category_row = mysqli_fetch_assoc($category_res);
                            if ($category_row) {
                                $title = $category_row['category'];
                                echo '<option value="' . $category_id . '">' . $title . '</option>';
                            }
                        }
                    } else {
                        echo '<option value="0">No Category Found</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>

            <tr>
                <td>Brands: </td>
                <td>
                <select name="brand" id="brand">
                <option value="">Select a category first</option>
            </select>
                </td>
            </tr>
           <tr>
            <td>Title:</td>
            <td>
                <input type="text" name="title" placeholder="Title of the bike">
            </td>
           </tr>
           <tr>
            <td>Description: </td>
            <td>
                <textarea name="description" id="" cols="30" rows="5" placeholder="Description of the products"></textarea>
            </td>
           </tr>

           <tr>
            <td>Price: </td>
            <td>
                <input type="number" name="price">
            </td>
           </tr>

           <tr>
            <td>Select Image</td>
            <td>
                <input type="file" name="image">
            </td>
           </tr>

          

        

            <tr>
                <td coolspan="2">
                    <input type="submit" name="submit" value="Add Product" class="btn-secondary">
                </td>
            </tr>

          </table>
        </form>
           
        
    <?php

        if(isset($_POST['submit']))
        {


            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category_id'];
            $brand = $_POST['brand'];

            // Check if any of the input fields is empty
            if(empty($title) || empty($description) || empty($price) || empty($category) || empty($brand))
            {
                $_SESSION['error'] = "<div class='error'>All fields are required.</div>";
                header('location: ' . SITEURL . 'admin/add-product-list.php');
                die();
            }

            // Set the status to "Active" (Yes) by default
            $status = 1;

            // Check if the title already exists in the database
            $check_sql = "SELECT * FROM product_list WHERE name = '$title'";
            $check_result = mysqli_query($conn, $check_sql);

            if(mysqli_num_rows($check_result) > 0)
            {
                $_SESSION['error'] = "<div class='error'>Title already exists.</div>";
                header('location: ' . SITEURL . 'admin/add-product-list.php');
                die();
            }

                if (isset($_FILES['image']['name']))
                {
                    $image_name = $_FILES['image']['name'];

                    if($image_name != "")
                    {
                        $ext = pathinfo($image_name, PATHINFO_EXTENSION);

                        $image_name = "Bike-Name" . rand(0000,9999) . "." . $ext;

                        $src = $_FILES['image']['tmp_name'];
                        $dst = "../images/bike/" . $image_name;

                        $upload = move_uploaded_file($src, $dst);

                        if(!$upload)
                        {
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                            header('location: '.SITEURL.'admin/add-product-list.php');
                            die();
                        }
                    }
                }
                else
                {
                    $image_name = "";
                }

                // Assuming $conn is a valid database connection
                $sql = "INSERT INTO product_list (name, description, brand_id, price, image_path, category_id, status)
                        VALUES ('$title', '$description', '$brand', '$price', '$image_name', '$category', '$status')";

                $res = mysqli_query($conn, $sql);

                if ($res)
                {
                    $_SESSION['add'] = "<div class='success'>Product Added Successfully.</div>";
                    header('location: ' . SITEURL . 'admin/product-list.php');
                }
                else
                {
                    $_SESSION['add'] = "<div class='error'>Failed to Add Product.</div>";
                    header('location: ' . SITEURL . 'admin/product-list.php');
                }
            }
    ?>


           

    </div>
</div>

<script>
function fetchBrands() {
    var category_id = $("#category_id").val();
    var brandDropdown = $("#brand");

    if (category_id) {
        $.ajax({
            type: "GET",
            url: "get_brands.php",
            data: { categoryId: category_id }, // Use categoryId as the parameter name
            dataType: "html",
            success: function (response) {
                if (response.trim() !== "") {
                    brandDropdown.html(response);
                } else {
                    brandDropdown.html('<option value="">No Brands Found</option>');
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
            }
        });
    } else {
        brandDropdown.html('<option value="">Select a Category First</option>');
    }
}

// Attach the event listener to the category dropdown
$(document).ready(function() {
    $("#category_id").change(fetchBrands);
});
</script>

<?php include('partials/footer.php'); ?>