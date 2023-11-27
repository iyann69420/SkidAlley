<?php include('partials/menu.php'); ?>
<form action="" method="POST">
    <div class="main-content">
        <div class="wrapper">
            <h1>Add Inventory</h1>
            <br><br>
            <?php
            if (isset($_SESSION['error'])) {
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            }
            ?>

            <table class="tbl-30">
                <tr>
                    <td>Select a Product: </td>
                    <td>
                        <select name="product" id="product" onchange="fetchColorsAndSizes()">
                            <?php
                            $sql = "SELECT p.id, p.name AS product_name, b.name AS brand_name
                                    FROM product_list p
                                    JOIN brand_list b ON p.brand_id = b.id
                                    WHERE p.status='1'";
                            $res = mysqli_query($conn, $sql);

                            $count = mysqli_num_rows($res);

                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $id = $row['id'];
                                    $productName = $row['product_name'];
                                    $brandName = $row['brand_name'];
                                    echo '<option value="' . $id . '">' . $productName . ' - ' . $brandName . '</option>';
                                }
                            } else {
                                echo '<option value="0">No Product Found</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Product Image</td>
                    <td colspan="2">
                        <img id="productImage" src="" alt="Product Image" width="100">
                    </td>
                </tr>
                <tr>
                    <td>Colors and Sizes:</td>
                    <td>
                     <!-- Modify the "Colors and Sizes" select to add the "disabled" attribute initially -->
                        <select name="color_size" id="color_size" onchange="updateProductColorsSizesId()" disabled>
                            <option value="">Select a Product First</option>
                        </select>

                    </td>
                </tr>
                <tr>
                    <td>Quantity:</td>
                    <td>
                        <input type="number" name="quantity">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Stocks" class="btn-secondary">
                    </td>
                </tr>
                <input type="hidden" name="product_colors_sizes_id" id="product_colors_sizes_id" value="">

            </table>
        </div>
    </div>
</form>

<?php include('partials/footer.php') ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Get references to the select element and image element
    const productSelect = document.querySelector('select[name="product"]');
    const productImage = document.getElementById('productImage');

    // Define an empty object to store product images
    const productImages = {};

    // Define an array to store sizes
    const sizes = [];

    <?php
    $sql = "SELECT id, image_path FROM product_list WHERE status='1'";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $id = $row['id'];
            $imagePath = $row['image_path'];
            echo "productImages['$id'] = '../images/bike/$imagePath';"; // Assuming the images are in the "images/bike/" directory
        }
    }
    ?>

    // Populate the sizes array with size values
    sizes.push("Small");
    sizes.push("Medium");
    sizes.push("Large");
    // Add more sizes as needed

    // Add an event listener to the select element
    productSelect.addEventListener('change', () => {
        const selectedProductId = productSelect.value;
        const imageUrl = productImages[selectedProductId] || '';
        productImage.src = imageUrl;
    });

    // Trigger the change event initially to display the default image
    productSelect.dispatchEvent(new Event('change'));
</script>


<script>
        // Function to fetch colors and sizes based on the selected product
    function fetchColorsAndSizes() {
    var product = $("#product").val();
    var colorSizeDropdown = $("#color_size");
    
    
    if (product) {
        $.ajax({
            type: "GET",
            url: "get_colors_sizes.php",
            data: { product: product },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    colorSizeDropdown.empty();

                    for (var i = 0; i < response.data.length; i++) {
                        var colorSize = response.data[i];
                        var option = $("<option>").val(colorSize.id).text(colorSize.color + ' - ' + colorSize.size);
                        colorSizeDropdown.append(option);
                    }

                    $("#product_colors_sizes_id").val('');
                    // Enable the dropdown since a product is selected
                    colorSizeDropdown.prop('disabled', false);
                } else {
                    colorSizeDropdown.html('<option value="">No Colors and Sizes Found</option>');
                    $("#product_colors_sizes_id").val('');
                    // Disable the dropdown if there are no colors and sizes found
                    colorSizeDropdown.prop('disabled', true);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
            }
        });
    } else {
        colorSizeDropdown.html('<option value="">Select a Product First</option>');
        $("#product_colors_sizes_id").val('');
        // Disable the dropdown if no product is selected
        colorSizeDropdown.prop('disabled', true);
    }
}

        // Function to update the hidden input when a color and size is selected
        function updateProductColorsSizesId() {
            var colorSizeId = $("#color_size").val();
            $("#product_colors_sizes_id").val(colorSizeId);
        }
    </script>

<?php
if (isset($_POST['submit'])) {
    $product = $_POST['product'];
    $color_size = $_POST['color_size']; // This will contain the selected color and size combination (e.g., "Red-Large")
    $quantity = $_POST['quantity'];
 

    // Split the color_size value into separate color and size values
    $color_size_parts = explode('-', $color_size);
    if (count($color_size_parts) === 2) {
        $color = $color_size_parts[0];
        $size = $color_size_parts[1];
    } else {
        // Handle the case where the format is invalid (e.g., no hyphen)
        // You can set default values or display an error message.
        // For example:
        $color = 'Unknown';
        $size = 'Unknown';
        // You can also add code to set an error message here.
    }

    // Check if the product/color/size combination is already in the stock_list table
    $check_sql = "SELECT * FROM stock_list WHERE product_id = '$product' AND product_colors_sizes_id = '$color_size'";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) > 0) {
        // Update the existing row
        $update_sql = "UPDATE stock_list SET quantity = quantity + $quantity WHERE product_id = '$product' AND product_colors_sizes_id = '$color_size'";
        $update_res = mysqli_query($conn, $update_sql);

        if ($update_res) {
            $_SESSION['add'] = "<div class='success'>Quantity Updated Successfully</div>";
            header("location:" . SITEURL . 'admin/inventory.php');
        } else {
            $_SESSION['error'] = "<div class='error'>Failed to Update Quantity</div>";
            header("location:" . SITEURL . 'admin/add-inventory.php');
        }
    } else {
        // Insert a new row
        $insert_sql = "INSERT INTO stock_list (product_id, product_colors_sizes_id, quantity) VALUES ('$product', '$color_size', $quantity)";
        $insert_res = mysqli_query($conn, $insert_sql);

        if ($insert_res) {
            $_SESSION['add'] = "<div class='success'>Stock Added Successfully</div>";
            header("location:" . SITEURL . 'admin/inventory.php');
        } else {
            $_SESSION['add'] = "<div class='error'>Failed to Add Stock</div>";
            header("location:" . SITEURL . 'admin/inventory.php');
        }
    }
}
?>
