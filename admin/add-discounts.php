<?php
include('partials/menu.php');

// Function to check if a record exists in a table
function checkIfExists($table, $column, $value)
{
    global $conn;
    $query = "SELECT COUNT(*) as count FROM $table WHERE $column = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return ($row['count'] > 0);
    }

    return false;
}

// Function to delete expired discounts
function deleteExpiredDiscounts()
{
    global $conn;

    $currentDateTime = date('Y-m-d H:i:s');
    $query = "DELETE FROM discounts WHERE end_time < ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $currentDateTime);
    $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Get data from the form
    $discount_for = $_POST['discount_for'];
    $product_id = ($_POST['product']) ? $_POST['product'] : null;
    $brand_id = ($_POST['brand']) ? $_POST['brand'] : null;
    $category_id = ($_POST['category']) ? $_POST['category'] : null;
    $discount_percentage = $_POST['discount_percentage'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Validate and sanitize the data if needed

    // Check if the selected product, brand, or category exists before inserting into the discounts table
    $exists = false;

    switch ($discount_for) {
        case 'product':
            $exists = checkIfExists('product_list', 'id', $product_id);
            break;

        case 'brand':
            $exists = checkIfExists('brand_list', 'id', $brand_id);
            break;

        case 'category':
            $exists = checkIfExists('categories', 'id', $category_id);
            break;

        default:
            echo "Invalid discount option";
            exit();
    }

   
    // Insert data into the discounts table based on the selected option
    switch ($discount_for) {
        case 'product':
            $stmt = $conn->prepare("INSERT INTO discounts (product_id, discount_percentage, start_time, end_time) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $product_id, $discount_percentage, $start_time, $end_time);
            break;

        case 'brand':
            $stmt = $conn->prepare("INSERT INTO discounts (brand_id, discount_percentage, start_time, end_time) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $brand_id, $discount_percentage, $start_time, $end_time);
            break;

        case 'category':
            $stmt = $conn->prepare("INSERT INTO discounts (category_id, discount_percentage, start_time, end_time) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $category_id, $discount_percentage, $start_time, $end_time);
            break;

        default:
            echo "Invalid discount option";
            exit();
    }

    if ($stmt->execute()) {
        // Successful insertion, delete expired discounts
        deleteExpiredDiscounts();

        // Redirect to a success page or show a success message
        header("Location: discounts.php");
        exit();
    } else {
        // Display an error message if the insertion fails
        echo "Error: " . $stmt->error;
    }
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Discounts </h1>
        <br><br>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Discount For</td>
                    <td>
                        <select name="discount_for" id="discount_for">
                            <option value="product">Specific Product</option>
                            <option value="brand"> Brand</option>
                            <option value="category"> Category</option>
                        </select>
                    </td>
                    <input type="hidden" name="selected_option" id="selected_option" value="product">
                </tr>

                <tr id="productDropdown">
                    <td>Product</td>
                    <td>
                        <select name="product">
                            <?php
                            $sql = "SELECT id, name FROM product_list WHERE delete_flag = 0";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No products found</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr id="brandDropdown" style="display: none;">
                    <td>Brand</td>
                    <td>
                        <select name="brand">
                            <?php
                            $sql = "SELECT id, name FROM brand_list WHERE status = 1";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No brands found</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr id="categoryDropdown" style="display: none;">
                    <td>Category</td>
                    <td>
                        <select name="category">
                            <?php
                            $sql = "SELECT id, category FROM categories WHERE status = 1";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['category'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No categories found</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Discount Percentage:</td>
                    <td>
                        <input type="number" name="discount_percentage" min="0" max="100" step="0.01" placeholder="Enter discount percentage">
                    </td>
                </tr>

                <tr>
                    <td>Start Time:</td>
                    <td>
                        <input type="datetime-local" name="start_time" placeholder="Enter start time">
                    </td>
                </tr>
                <tr>
                    <td>End Time:</td>
                    <td>
                        <input type="datetime-local" name="end_time" placeholder="Enter end time">
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

<script>
    
      document.getElementById('discount_for').addEventListener('change', function () {
        var selectedOption = this.value;
        document.getElementById('selected_option').value = selectedOption;

        document.getElementById('productDropdown').style.display = (selectedOption === 'product') ? 'table-row' : 'none';
        document.getElementById('brandDropdown').style.display = (selectedOption === 'brand') ? 'table-row' : 'none';
        document.getElementById('categoryDropdown').style.display = (selectedOption === 'category') ? 'table-row' : 'none';
    });

    document.getElementById('submitBtn').addEventListener('click', function (event) {
        var discountPercentage = document.getElementsByName('discount_percentage')[0].value;
        var startTime = document.getElementsByName('start_time')[0].value;
        var endTime = document.getElementsByName('end_time')[0].value;

        if (discountPercentage === '' || startTime === '' || endTime === '') {
            event.preventDefault(); // Prevent form submission
            alertify.error('Please fill in all required fields.');
        }
    });

    
</script>

<?php include('partials/footer.php') ?>