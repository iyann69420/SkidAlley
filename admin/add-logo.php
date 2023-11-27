<?php include('partials/menu.php'); ?>
 
<div class="main-content">
    <div class="wrapper">
        <h1>Add Logo</h1>

        <br><br>

        <?php
        
          if(isset($_SESSION['upload']))
          {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
          }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Select Image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Logo" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
   

        if(isset($_POST['submit']))
        {
            $image_name = $_FILES['image']['name'];

            if($image_name != "")
            {
                $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                $image_name = "Logo-" . rand(0000, 9999) . "." . $ext;
                $src = $_FILES['image']['tmp_name'];
                $dst = "../images/logo/" . $image_name;

                if(move_uploaded_file($src, $dst))
                {
                    // Image uploaded successfully
                }
                else
                {
                    $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                    header('location: ' . SITEURL . 'admin/add-logo.php');
                    die();
                }
            }
            else
            {
                $image_name = "";
            }

            $sql = "INSERT INTO content_management_logo (logo) VALUES ('$image_name')";
            $res = mysqli_query($conn, $sql);

            if ($res)
            {
                $_SESSION['add'] = "<div class='success'>Logo Added Successfully.</div>";
                header('location: ' . SITEURL . 'admin/logo.php');
            }
            else
            {
                $_SESSION['add'] = "<div class='error'>Failed to Add Logo.</div>";
                header('location: ' . SITEURL . 'admin/logo.php');
            }
        }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>
