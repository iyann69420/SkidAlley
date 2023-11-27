<?php
include('partials/menu.php');

$description = ""; // Initialize $description with an empty string

if (isset($_POST['submit'])) {
    $contactus = mysqli_real_escape_string($conn, $_POST['description']); // Escape the input

    // Check if the description is empty
    if (empty($contactus)) {
        echo "<div class='error'>Please input a description.</div>";
    } else {
        $sql = "INSERT INTO content_management_contactus (contactus) VALUES ('$contactus')";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            $_SESSION['add'] = "<div class='success'>About Us Added.</div>";
            header('location: ' . SITEURL . 'admin/contactus.php');
        } else {
            $_SESSION['add'] = "<div class='error'>Failed to Add.</div>";
            header('location: ' . SITEURL . 'admin/contactus.php');
        }
    }
}
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
        <h1>Add Content for Contact Us</h1>

        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" id="description" cols="30" class="mySummerNote"
                            style="width: 100%;"><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Product" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <script>
            document.getElementById('font-select').addEventListener('change', function() {
                const selectedFont = this.value;
                document.getElementById('description').style.fontFamily = selectedFont;
            });
        </script>

        <!-- Rest of your code -->

    </div>
</div>

<?php include('partials/footer.php'); ?>
