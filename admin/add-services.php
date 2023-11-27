<?php include('partials/menu.php'); ?>
 
<div class="main-content">
    <div class ="wrapper">
        <h1>Add Service</h1>

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
                <td>Service Name:</td>
                <td>
                    <input type="text" name="title" placeholder="Category Title">
                </td>
            </tr>

            <tr>
            <td>Description: </td>
            <td>
                <textarea name="description" id="" cols="30" rows="5" placeholder="Description of the service"></textarea>
            </td>
           </tr>
           
            <tr>
                <td>Status:</td>
                <td>
                    <input type="radio" name="status" value="Yes"> Active
                    <input type="radio" name="status" value="No"> Inactive
                </td>
            </tr>


            <tr>
                <td coolspan="3">
                    <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                </td>
            </tr>

           </table>
        </form>

        <?php
       
        if (isset($_POST['submit'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];
        
            $status = 0; // Default value

            if (isset($_POST['status']) && $_POST['status'] === "Yes") {
                $status = 1; // Set to 1 if "Yes" is selected
            }

            $sql = "INSERT INTO service_list (service, description, status)
                    VALUES ('$title','$description', '$status')";
        
            $res = mysqli_query($conn, $sql);
        
            if ($res == true) {
                $_SESSION['add'] = "<div class='success'> Service Added Successfully. </div>";
                header('location: '.SITEURL.'admin/services.php');
            } else {
                $_SESSION['add'] = "<div class='error'> Failed to Add Service. </div>";
                header('location: '.SITEURL.'admin/services.php');
            }
        }
        ?>
        
    </div>
</div>


<?php include('partials/footer.php'); ?>