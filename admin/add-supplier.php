<?php include('partials/menu.php'); ?>
 
<div class="main-content">
    <div class ="wrapper">
        <h1>Add Supplier</h1>

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
                <td>Supplier Name:</td>
                <td>
                    <input type="text" name="suppliername" placeholder="Add Supplier Name">
                </td>
            </tr>

            <tr>
                <td>Contact: </td>
                <td>
                    <input type="number" name="contact" >
                </td>
            </tr>

            <tr>
                <td>Address: </td>
                <td>
                    <input type="text" name="address" >
                </td>
            </tr>

            <tr>
                <td>Email: </td>
                <td>
                    <input type="email" name="email">
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
            $suppliername = $_POST['suppliername'];
            $address = $_POST['address'];
            $contact = $_POST['contact'];
            $email = $_POST['email'];

            if (empty($suppliername) || empty($address) || empty($contact) || empty($email)) {
                $_SESSION['add'] = "<div class='error'> All fields are required. Please fill in all the fields. </div>";
                header('location: '.SITEURL.'admin/add-supplier.php');
                exit();
                
            }
        
          

            $sql = "INSERT INTO supplier_list (supplier_name, address, contact, email)
            VALUES ('$suppliername', '$address', '$contact', '$email')";
        
            $res = mysqli_query($conn, $sql);
        
            if ($res == true) {
                $_SESSION['add'] = "<div class='success'> Supplier Added Successfully. </div>";
                header('location: '.SITEURL.'admin/supplier.php');
            } else {
                $_SESSION['add'] = "<div class='error'> Failed to Add Supplier. </div>";
                header('location: '.SITEURL.'admin/supplier.php');
            }
        }
        ?>
        
    </div>
</div>


<?php include('partials/footer.php'); ?>