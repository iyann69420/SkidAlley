<?php include('partials/menu.php'); ?>
 
<div class="main-content">
    <div class ="wrapper">
        <h1>Add Brands</h1>

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
                <td>Brand Name:</td>
                <td>
                    <input type="text" name="title" placeholder="Brand Name">
                </td>
            </tr>
           

            <tr>
                <td coolspan="2">
                    <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                </td>
            </tr>

           </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $title = $_POST['title'];
        
            // Check if the category title is empty
            if (empty($title)) {
                echo "<div class='error'>Please input a brand.</div>";
            } else {
                // Set the status to "Active" (Yes) by default
                $status = 1;
        
                // Check if the category title already exists
                $check_sql = "SELECT * FROM brand_list WHERE name = '$title'";
                $check_result = mysqli_query($conn, $check_sql);
        
                if (mysqli_num_rows($check_result) > 0) {
                    // Category title already exists, show an error message
                    $_SESSION['add'] = "<div class='error'>Brand Name already exists.</div>";
                    header('location: '.SITEURL.'admin/add-brands.php');
                } else {
                    // Insert the new category into the database with status "Active" (Yes)
                    $insert_sql = "INSERT INTO brand_list (name, status) VALUES ('$title', '$status')";
                    $insert_result = mysqli_query($conn, $insert_sql);
        
                    if ($insert_result) {
                        $_SESSION['add'] = "<div class='success'>Brands Added Successfully.</div>";
                        header('location: '.SITEURL.'admin/brands.php');
                    } else {
                        $_SESSION['add'] = "<div class='error'>Brands to Add Category.</div>";
                        header('location: '.SITEURL.'admin/brands.php');
                    }
                }
            }
        }
        
        ?>

        
        
    </div>
</div>


<?php include('partials/footer.php'); ?>