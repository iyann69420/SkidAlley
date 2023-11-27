<?php include ('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Client</h1>
        <br><br>

        <?php
            $id=$_GET['id'];

            $sql="SELECT * FROM client_list WHERE id = $id";

            $res=mysqli_query($conn, $sql);

            if($res==true)
            {
              $count = mysqli_num_rows($res);
              if($count==1)
              {
               $row=mysqli_fetch_assoc($res);

               $fullname = $row['username'];
               $username = $row['fullname'];
               $contact = $row['contact'];
               $address = $row['address'];
               $email = $row['email'];
               $status = $row['status'];
              }
              else
              {
                header('location:'.SITEURL.'admin/client_list.php');
              }
            }

           ?>


        <form action="" method="POST">

                <table class="tbl-30">
                            <tr>
                        <td>Username: </td>
                        <td>
                            <input type="text" name="username" value="<?php echo $username; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Fullname: </td>
                        <td>
                            
                            <input type="text" name="fullname" value="<?php echo $fullname; ?>">
                        </td>
                    </tr>

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
                    <td>Status:</td>
                        <td>
                            <input <?php if ($status == 1) { echo "checked"; } ?> type="radio" name="status" value="1"> Active
                            <input <?php if ($status == 0) { echo "checked"; } ?> type="radio" name="status" value="0"> Inactive
                        </td>
                    </tr>
                     
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Update Client" class="btn-secondary">
                        </td>
                    </tr>

                </table>

           </form>

           <?php
        if (isset($_POST['submit'])) 
        {
            $id = $_POST['id'];
            $username = $_POST['username'];
            
            $fullname = $_POST['fullname'];
            
            $contact = $_POST['contact'];
            
            $address = $_POST['address'];
            
            $email = $_POST['email'];
            $status = isset($_POST['status']) ? $_POST['status'] : 'No';

            $sql2 = "UPDATE client_list SET
                    username = '$username',
                    fullname = '$fullname',
                    contact = '$contact',
                    address = '$address',
                    email = '$email',
                    status = '$status'
                    WHERE id=$id";

            $res2 = mysqli_query($conn, $sql2);
            
            if($res==true){
                $_SESSION['update'] = "<div class ='success'>Client Updated Sucessfully.</div>";
                header('location:'.SITEURL.'admin/clients.php');

            }
            else
            {
                $_SESSION['update'] = "<div class ='error'>Failed to Update Client.</div>";
                header('location:'.SITEURL.'admin/clients.php');

            }
   
           
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php') ?>