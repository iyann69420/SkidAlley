<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Product</h1>
        <br><br>

        <?php
          if(isset($_SESSION['error']))
          {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
          }
        ?>

        <?php
        // Initialize $id with a default value
        $id = 0;

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

        } 
        else 
        {
            header('location: ' . SITEURL . 'admin/product-list.php');
            exit();
        } ?>

        <?php
         if (isset($_POST['submit']))
         {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category_id'];
            $current_image = $_POST['current_image'];
            $brand = $_POST['brand'];
            $active = $_POST['status'];

            if (empty($title) || empty($description) || empty($price) || empty($category) || empty($brand)) {
                $_SESSION['error'] = "<div class='error'>All fields are required.</div>";
                header('location: ' . SITEURL . 'admin/update-product-list.php?id=' . $id);
                die();
            }

            // Check if the title already exists
            $check_sql = "SELECT * FROM product_list WHERE name='$title' AND id != $id";
            $check_result = mysqli_query($conn, $check_sql);

            if (mysqli_num_rows($check_result) > 0) {
                $_SESSION['error'] = "<div class='error'>Title already exists.</div>";
                header('location: ' . SITEURL . 'admin/update-product-list.php?id=' . $id);
                die();
            }


            //check whether upload button is clicked or not 
            if (isset($_FILES['image']['name'])) 
            {
                //upload button clicked
                $image_name = $_FILES['image']['name']; //new image name 


                //check whether the file is available or not
                if($image_name!="")
                {
                    //image name available 
                    //rename the image
                    $ext = end(explode('.', $image_name));//gets the extension of the image
                    $image_name = "Bike-Name-".rand(0000,9999).'.'.$ext; //this will be renamed image


                    //get the source path and destionation path
                    $src_path = $_FILES['image']['tmp_name'];
                    $dest_path = "../images/bike/".$image_name;
                    
                    //upload the image 
                    $upload = move_uploaded_file($src_path, $dest_path);


                    //check whether the image is uploaded or not
                    if($upload==false)
                    {
                        //failed to upload
                        $_SESSION['upload'] = "<div class='error'>Failed to Remove Current Image.</div>";
                        //redirect to product list
                        header('location: ' . SITEURL . 'admin/product-list.php');
                        //stop the process
                        die();
                    }
                    //remove the current image if available
                    if($current_image!="")
                    {
                        //remove the image
                        $remove_path = "../images/bike/".$current_image;

                        $remove = unlink($remove_path);
                        //check whether its remove or not 
                        if($remove==false)
                        {
                            //failed to remove
                            $_SESSION['remove-failed'] = "<div class='error'>Failed to Remove Current Image.</div>";
                            header('location: ' . SITEURL . 'admin/product-list.php');
                            die();
                    }
                }
            } 
            else
            {
                $image_name = $current_image; 
            }
        }
            else 
            {
                $image_name = $current_image;
            } 

            


            $sql3 = "UPDATE product_list SET
            name = ?,
            description = ?,
            brand_id = ?,
            price = ?,
            image_path = ?,
            category_id = ?,
            status = ?
            WHERE id = ?";
        
        $stmt = mysqli_prepare($conn, $sql3);
        
        mysqli_stmt_bind_param($stmt, "sssssssi", $title, $description, $brand, $price, $image_name, $category, $active, $id);
        
        $res3 = mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);

            if($res3==true)
            {
                $_SESSION['update'] = "<div class='success'>Product Update Successfully.</div>";
                header('location: ' . SITEURL . 'admin/product-list.php');
                exit();



            }
            else
            {
                $_SESSION['update'] = "<div class='error'>Failed to Update Product.</div>";
                header('location: ' . SITEURL . 'admin/product-list.php');
                exit();
                
            }
            
            
            
         }
        ?>
      

        <?php
            

            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql2 = "SELECT * FROM product_list WHERE id = $id";
                $res2 = mysqli_query($conn, $sql2);

                if ($res2) {
                    $row2 = mysqli_fetch_assoc($res2);

                    $title = $row2['name'];
                    $description = $row2['description'];
                    $price = $row2['price'];
                    $category = $row2['category_id'];
                    $brand = $row2['brand_id'];
                    $current_image = $row2['image_path'];
                    $active = $row2['status'];
                } else {
                    // Handle the error or redirect as needed
                }
            } else {
                header('location: ' . SITEURL . 'admin/product-list.php');
                exit(); // Add exit to stop further execution
            }
        ?>

       

        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">

            <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category_id" id="category_id">
                        <?php
                        $sql = "SELECT id, category FROM categories";
                        $res = mysqli_query($conn, $sql);

                        if ($res) {
                            $count = mysqli_num_rows($res);

                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $categoryId = $row['id'];
                                    $categoryTitle = $row['category'];
                                    ?>
                                    <option value="<?php echo $categoryId; ?>" <?php if ($category == $categoryId) { echo 'selected'; } ?>><?php echo $categoryTitle; ?></option>
                                    <?php
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
                    <td>Brand: </td>
                    <td>
                        <select name="brand" id="brand">
                        <?php
                        $sql = "SELECT * FROM brand_list WHERE status='1'";
                        $res = mysqli_query($conn, $sql);

                        if ($res) {
                            $count = mysqli_num_rows($res);

                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $brandId = $row['id'];
                                    $brandName = $row['name'];
                                    ?>
                                    <option value="<?php echo $brandId; ?>" <?php if ($brand == $brandId) { echo 'selected'; } ?>><?php echo $brandName; ?></option>
                                    <?php
                                }
                            } else {
                                echo '<option value="0">No Brand Found</option>';
                            }
                        } else {
                            echo '<option value="0">No Brand Found</option>';
                        }
                        ?>
                       
                        </select>
                    </td>
                </tr>


                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo isset($title) ? $title : ''; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" ><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image</td>
                    <td>
                    <?php
                        if($current_image == "")
                        {
                           echo "<div class ='error'>Image not Available.</div>";
                        }
                        else
                        {
                            ?>
                            <img src="<?php echo SITEURL; ?>images/bike/<?php echo $current_image; ?>"
                                     width="200px">
                            <?php

                        }
                        ?>
                       
                    </td>
                </tr>

                <tr>
                    <td>Select Image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>


                

              
                <tr>
                    <td>Status:</td>
                    <td>
                        <input <?php if ($active == 1) { echo "checked"; } ?> type="radio" name="status" value="1"> Active
                        <input <?php if ($active == 0) { echo "checked"; } ?> type="radio" name="status" value="0"> Inactive
                        
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        
                        <input type="submit" name="submit" value="Update Product" class="btn-secondary">

                    </td>
                </tr>

            </table>

        </form>
       
       
    </div>
</div>


<?php include('partials/footer.php');?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    function fetchBrands() {
        var category_id = $("#category_id").val();
        var brandDropdown = $("#brand");

        if (category_id) {
            $.ajax({
                type: "GET",
                url: "get_brands.php",
                data: { categoryId: category_id }, // Adjust the parameter name to categoryId
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
    $(document).ready(function () {
        $("#category_id").change(fetchBrands);
    });
</script>

<?php include('partials/footer.php'); ?>