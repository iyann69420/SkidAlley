<?php include ('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Reviews</h1>
        <br><br>

        <?php
        $id = $_GET['id'];

        $sql = "SELECT * FROM reviews WHERE id = $id";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        if (isset($_GET['id'])) 
        {
            if ($count == 1) 
            {
                $row = mysqli_fetch_assoc($res);
                $order_id = $row['order_id'];
                $client_id = $row['client_id'];
                $image = $row['image_path'];
                $stars = $row['stars'];
                $review_text = $row['review_text'];
                $approved = $row['approved'];
                $reply = $row['reply'];
            } 
            else 
            {
                $_SESSION['no-service-found'] = "<div class='error'> Service not found</div>";
                header('location:' . SITEURL . 'admin/reviews.php');
                exit();
            }
        } 
        else 
        {
            header('location:' . SITEURL . 'admin/reviews.php');
            exit();
        }
        ?>

        <br><br>

        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <table class="tbl-30">


                <tr>
                    <td>Client Id: </td>
                    <td>
                        <?php echo $client_id; ?>
                    </td>
                </tr>

                <tr>
                    <td>Image:</td>
                    <td>
                            <?php
                            if ($image == "") 
                            {
                                echo "<div class='error'>Image not Added.</div>";
                            } else {
                                ?>
                                <img src="<?php echo SITEURL; ?>images/reviews/<?php echo $image; ?>"
                                     width="100px">
                                <?php
                            }
                            ?>
                        </td>
                </tr>


                <tr>
                    <td>Review: </td>
                    <td>
                        <?php echo $review_text; ?>
                    </td>
                </tr>

                <tr>
                    <td>Reply: </td>
                    <td>
                        <input type="text" name="reply" value="<?php echo $reply; ?>">
                    </td>
                </tr>

                

                <tr>
                    <td>Approved:</td>
                    <td>
                        <input <?php if ($approved == 1) { echo "checked"; } ?> type="radio" name="approved" value="1"> Yes
                        <input <?php if ($approved == 0) { echo "checked"; } ?> type="radio" name="approved" value="0"> No
                    </td>
                </tr>


                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Update Review" class="btn-secondary">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $reply = $_POST['reply'];
            $approved = isset($_POST['approved']) ? $_POST['approved'] : 0;

        
            $sql2 = "UPDATE reviews SET
                reply = '$reply',
                approved = '$approved'
                WHERE id=$id";
        
            $res2 = mysqli_query($conn, $sql2);
        
            if($res==true){
                $_SESSION['update'] = "<div class ='success'>Review Updated Sucessfully.</div>";
                header('location:'.SITEURL.'admin/reviews.php');

            }
            else
            {
                $_SESSION['update'] = "<div class ='error'>Failed to Update Review.</div>";
                header('location:'.SITEURL.'admin/reveiws.php');


            }
           
        }
        ?>
    </div>
</div>

<?php include ('partials/footer.php');?>
