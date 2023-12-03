<?php
include('partials/menu.php');




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST['name'];
    $number = $_POST['number'];

   
    if (empty($name) || empty($number)) {
        echo '<script>alertify.error("Please enter both name and number.");</script>';
    } elseif (strlen($number) != 11 || !ctype_digit($number)) {
        echo '<script>alertify.error("Please enter a valid 11-digit number.");</script>';
    } else {
   
        $checkSql = "SELECT * FROM gcash_infos WHERE number = '$number'";
        $checkResult = $conn->query($checkSql);

        if ($checkResult->num_rows > 0) {
    
            $updateSql = "UPDATE gcash_infos SET name = '$name' WHERE number = '$number'";

            if ($conn->query($updateSql) === TRUE) {
           
                echo '<script>alertify.success("Record updated successfully");</script>';
            } else {
           
                echo '<script>alertify.error("Error updating record: ' . $conn->error . '");</script>';
            }
        } else {
        
            $insertSql = "INSERT INTO gcash_infos (name, number) VALUES ('$name', '$number')";

            if ($conn->query($insertSql) === TRUE) {
               
                echo '<script>alertify.success("Record added successfully");</script>';
            } else {
                
                echo '<script>alertify.error("Error adding record: ' . $conn->error . '");</script>';
            }
        }
    }
}


$conn->close();
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Gcash Info </h1>
        <br><br>

        <form action="" method="POST">

            <table class="tbl-30">
            <tr>
                    <td>Name</td>
                    <td>
                        <input type="text" name="name" placeholder="Enter Name" required>
                    </td>
                </tr>
                <tr>
                    <td>Number</td>
                    <td>
                        <input type="text" name="number" placeholder="Enter Number" required>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" id="submitBtn" value="Add Discount" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/themes/default.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>

<?php include('partials/footer.php') ?>

<script>
    $(document).ready(function () {
        // Your Alertify code here
        alertify.set('notifier', 'position', 'bottom-right');

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (strlen($number) != 11 || !ctype_digit($number)) {
                echo 'alertify.error("Please enter a valid 11-digit number.");';
            } else {
                echo 'alertify.success("Record added successfully");';
            }
        }
        ?>
    });
</script>