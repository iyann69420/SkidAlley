<?php
include('partials/menu.php');
?>

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
        <h1>Update Content For About Us</h1>
        <br><br>

        <?php
           
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $aboutus = mysqli_real_escape_string($conn, $_POST['description']);
            $aboutus = trim($aboutus);

            // Check if 'Description' is not empty
            if (empty($aboutus)) {
                echo "<div class='error'>Please input a description.</div>";

            } else {
                $sql3 = "UPDATE content_management_aboutus SET aboutus = '$aboutus' WHERE id = $id";

                $res3 = mysqli_query($conn, $sql3);

                if ($res3 == true) {
                    $_SESSION['update'] = "<div class='success'> Update Successfully.</div>";
                    header('location: ' . SITEURL . 'admin/aboutus.php');
                    exit();
                } else {
                    $_SESSION['update'] = "<div class='error'>Failed to Update.</div>";
                    header('location: ' . SITEURL . 'admin/aboutus.php');
                    exit();
                }
            }
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $sql2 = "SELECT * FROM content_management_aboutus WHERE id = $id";
            $res2 = mysqli_query($conn, $sql2);

            if ($res2) {
                $row2 = mysqli_fetch_assoc($res2);

                $description = $row2['aboutus'];
            } else {
                // Handle the error or redirect as needed
            }
        } else {
            header('location: ' . SITEURL . 'admin/aboutus.php');
            exit();
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
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update " class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>
