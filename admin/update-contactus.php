<?php include('partials/menu.php'); ?>
<!-- Include the Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<!-- Include the Summernote JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $(document).ready(function() {
        $(".mySummerNote").summernote({
            height: 500, // Set the desired height for the editor
           
        });

       
    });
</script>
<style>
    .note-editor {
        width: 500%;
    }
</style>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Content For Contact Us</h1>
        <br><br>

        <?php
      if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $contactus = mysqli_real_escape_string($conn, $_POST['description']);
      

        // Check if 'Description' and 'Font Size' are not empty
        if (empty($contactus)) {
            echo "<div class='error'>Please input a description.</div>";
        } else {
            $sql3 = "UPDATE content_management_contactus SET contactus = '$contactus' WHERE id = $id";

            $res3 = mysqli_query($conn, $sql3);

            if ($res3 == true) {
                $_SESSION['update'] = "<div class='success'> Update Successfully.</div>";
                header('location: ' . SITEURL . 'admin/contactus.php');
                exit();
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to Update.</div>";
                header('location: ' . SITEURL . 'admin/contactus.php');
                exit();
            }
        }
    }
        ?>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $sql2 = "SELECT * FROM content_management_contactus WHERE id = $id";
            $res2 = mysqli_query($conn, $sql2);

            if ($res2) {
                $row2 = mysqli_fetch_assoc($res2);

                $description = $row2['contactus'];
               
            } else {
                // Handle the error or redirect as needed
            }
        } else {
            header('location: ' . SITEURL . 'admin/contactus.php');
            exit(); // Add exit to stop further execution
        }
        ?>

        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
            <tr>
                    <td>Description: </td>
                    <td>
                    <textarea name="description" id="description" cols="30" class="mySummerNote" style="width: 100%;"><?php echo $description; ?></textarea>
                    </td>
                    </td>
            </tr>

            

            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <!-- You don't need the current_image field in this context, so it can be removed -->

                    <input type="submit" name="submit" value="Update " class="btn-secondary">
                </td>
            </tr>
            </table>
        </form>

    
    </div>
</div>

<?php include('partials/footer.php'); ?>
