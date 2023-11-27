<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Colors And Sizes</h1>
        <?php
        if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }
        ?>

        <br><br>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Product</td>
                    <td>
                        <select name="product">
                            <?php
                            $sql = "SELECT p.id, p.name AS product_name, b.name AS brand_name
                                    FROM product_list p
                                    INNER JOIN brand_list b ON p.brand_id = b.id
                                    WHERE p.status='1'";
                            $res = mysqli_query($conn, $sql);

                            if ($res) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $id = $row['id'];
                                    $productName = $row['product_name'];
                                    $brandName = $row['brand_name'];
                                    echo '<option value="' . $id . '">' . $productName . ' - ' . $brandName . '</option>';
                                }
                            } else {
                                echo '<option value="0">No Products Found</option>';
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
                    <td>Color:</td>
                    <td>
                        <input type="text" name="color" placeholder="Enter color">
                    </td>
                </tr>
                <tr>
                    <td>Size:</td>
                    <td>
                        <input type="text" name="sizes" placeholder="Enter sizes separated by commas">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Color and Size" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

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

<?php include('partials/footer.php') ?>

<?php
if (isset($_POST['submit'])) {
    // Get the selected product ID
    $selectedProductID = $_POST['product'];

    // Retrieve manually added color and size
    $color = $_POST['color'];

    // Get the sizes as a comma-separated string and split it into an array
    $sizesInput = $_POST['sizes'];
    $sizesArray = explode(',', $sizesInput);

    // Check if the color and sizes are not empty
    if (empty($color) || empty($sizesInput) || empty($sizesArray)) {
        $_SESSION['error'] = "<div class='error'>Color and size(s) cannot be empty</div>";
        // Redirect to the previous page or an appropriate error page
        header('location: ' . SITEURL . 'admin/add-colors-sizes.php');
        exit(); // Stop further execution
    }

    // Check if any of the sizes already exist for the selected product and color
    foreach ($sizesArray as $size) {
        $check_combination_sql = "SELECT * FROM product_colors_sizes WHERE product_id = '$selectedProductID' AND color = '$color' AND size = '$size'";
        $result = mysqli_query($conn, $check_combination_sql);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['error'] = "<div class='error'>Color and size combination already exists for size: $size</div>";
            header('location: ' . SITEURL . 'admin/add-colors-sizes.php');
            exit(); // Stop further execution
        }
    }

    // Insert the color and sizes into the product_colors_sizes table
    foreach ($sizesArray as $size) {
        $insert_color_size_sql = "INSERT INTO product_colors_sizes (product_id, color, size) VALUES ('$selectedProductID', '$color', '$size')";
        $result = mysqli_query($conn, $insert_color_size_sql);

        // Check if the insertion was successful
        if (!$result) {
            $_SESSION['error'] = "<div class='error'>Failed to add color and size</div>";
            header('location: ' . SITEURL . 'admin/add-colors-sizes.php');
            exit(); // Stop further execution
        }
    }

    $_SESSION['add'] = "<div class='success'>Color and size(s) added successfully</div>";
    header("location:" . SITEURL . 'admin/colors-sizes.php');
}

?>
