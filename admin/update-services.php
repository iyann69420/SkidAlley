<?php include ('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Service</h1>
        <br><br>

        <?php
        $id = $_GET['id'];

        $sql = "SELECT * FROM service_list WHERE id = $id";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        if (isset($_GET['id'])) 
        {
            if ($count == 1) 
            {
                $row = mysqli_fetch_assoc($res);
                $title = $row['service'];
                $description = $row['description'];
                $status = $row['status'];
            } 
            else 
            {
                $_SESSION['no-service-found'] = "<div class='error'> Service not found</div>";
                header('location:' . SITEURL . 'admin/services.php');
                exit();
            }
        } 
        else 
        {
            header('location:' . SITEURL . 'admin/services.php');
            exit();
        }
        ?>

        <br><br>

        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <table class="tbl-30">
                <tr>
                    <td>Service: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" ><?php echo $description; ?></textarea>
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
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) 
        {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $status = isset($_POST['status']) ? $_POST['status'] : 'No';

            $sql2 = "UPDATE service_list SET
                    service = '$title',
                    description = '$description',
                    status = '$status'
                    WHERE id=$id";

            $res2 = mysqli_query($conn, $sql2);
            
            if($res==true){
                $_SESSION['update'] = "<div class ='success'>Service Updated Sucessfully.</div>";
                header('location:'.SITEURL.'admin/services.php');

            }
            else
            {
                $_SESSION['update'] = "<div class ='error'>Failed to Update Service.</div>";
                header('location:'.SITEURL.'admin/service.php');


            }
   
           
        }
        ?>
    </div>
</div>

<?php include ('partials/footer.php');?>
