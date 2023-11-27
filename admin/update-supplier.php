<?php include ('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Supplier</h1>
        <br><br>

        <?php
            $id=$_GET['id'];

            $sql="SELECT * FROM supplier_list WHERE id = $id";

            $res=mysqli_query($conn, $sql);

            if($res==true)
            {
              $count = mysqli_num_rows($res);
              if($count==1)
              {
               $row=mysqli_fetch_assoc($res);

              
               $supplier_name = $row['supplier_name'];
               $contact = $row['contact'];
               $address = $row['address'];
               $email = $row['email'];
          
              }
              else
              {
                header('location:'.SITEURL.'admin/supplier.php');
              }
            }

           ?>


        <form action="" method="POST">

                <table class="tbl-30">
                            <tr>
                        <td>Supplier Name: </td>
                        <td>
                            <input type="text" name="supplier_name" value="<?php echo $supplier_name; ?>">
                        </td>
                    </tr>

                    <tr>
                   

                    <tr>
                        <td>Contact: </td>
                        <td>
                            <input type="number" name="contact" value="<?php echo $contact;?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Address: </td>
                        <td>
                            <input type="text" name="address" value="<?php echo $address;?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Email: </td>
                        <td>
                            <input type="email" name="email" value="<?php echo $email;?>">
                        </td>
                    </tr>

                     
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Update Supplier" class="btn-secondary">
                        </td>
                    </tr>

                </table>

           </form>

           <?php
        if (isset($_POST['submit'])) 
        {
            $id = $_POST['id'];
            $supplier_name = $_POST['supplier_name'];
            
          
            
            $contact = $_POST['contact'];
            
            $address = $_POST['address'];
            
            $email = $_POST['email'];

            if (empty($supplier_name) || empty($address) || empty($contact) || empty($email)) {
                $_SESSION['add'] = "<div class='error'> All fields are required. Please fill in all the fields. </div>";
                header('location: '.SITEURL.'admin/add-supplier.php');
                exit();
            }
          

            $sql2 = "UPDATE supplier_list SET
                    supplier_name = '$supplier_name',
                    contact = '$contact',
                    address = '$address',
                    email = '$email'
                    WHERE id=$id";

            $res2 = mysqli_query($conn, $sql2);
            
            if($res==true){
                $_SESSION['update'] = "<div class ='success'>Supplier Updated Sucessfully.</div>";
                header('location:'.SITEURL.'admin/supplier.php');

            }
            else
            {
                $_SESSION['update'] = "<div class ='error'>Failed to Update Supplier.</div>";
                header('location:'.SITEURL.'admin/supplier.php');

            }
   
           
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php') ?>