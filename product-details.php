<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<?php include('partials-front/menu.php'); ?>
<br><br><br><br><br><br><br>
<?php
if (isset($_SESSION['add'])) {
    echo $_SESSION['add'];
    unset($_SESSION['add']);
}
?>
<?php
$uniqueColors = [];
if (isset($_GET['id']) && is_numeric($_GET['id'])) 
{
    $product_id = $_GET['id'];



    // Fetch product details from the database
    $sql = "SELECT pl.*, sl.quantity AS stock_quantity 
            FROM product_list pl 
            LEFT JOIN stock_list sl ON pl.id = sl.product_id 
            WHERE pl.id = $product_id";
    $res = mysqli_query($conn, $sql);
    
    if ($res) 
    {
        $product_details = mysqli_fetch_assoc($res);
        if ($product_details) 
        {
            ?>
             <div class="product-image-container" id="product-image-container">
                    <img
                        id="product-image"
                        src="<?php echo SITEURL; ?>images/bike/<?php echo $product_details['image_path']; ?>"
                        alt="<?php echo $product_details['name']; ?>"
                        style="width: 300px">
                        
                        <div id="myresult" class="img-zoom-result"></div>

                        
                        
                   
                </div>

         


            <div class="product-details">
            <h1><?php echo $product_details['name']; ?></h1>


                <div class="product-description">
                    <p><?php echo $product_details['description']; ?></p>
                </div>

                <div class="product-price">
                    <p>Price: <?php echo $product_details['price']; ?></p>
                </div>

                <div class="product-sizes-colors">

                
                <h3>Colors:</h3>
                    <ul>
                    <?php
                    // Fetch distinct colors for the specified product
                    $colors_sql = "SELECT DISTINCT color FROM product_colors_sizes WHERE product_id = $product_id";
                    $colors_result = mysqli_query($conn, $colors_sql);

                    if ($colors_result) {
                        while ($color_row = mysqli_fetch_assoc($colors_result)) {
                            $color = $color_row['color'];

                            // Check if the color is not already in the uniqueColors array
                            if (!in_array($color, $uniqueColors)) {
                                $uniqueColors[] = $color;
                                echo "<button class='color-button' data-color='$color'>$color</button>";
                            }
                        }
                    } else {
                        echo "<p>No colors available.</p>";
                    }
                    ?>
                    </ul>

                    <h3>Sizes:</h3>
                    <ul>
                    <?php
                    // Fetch sizes for all colors but initially hide them
                    $sizes_sql = "SELECT size, color FROM product_colors_sizes WHERE product_id = $product_id";
                    $sizes_result = mysqli_query($conn, $sizes_sql);
                    while ($size_row = mysqli_fetch_assoc($sizes_result)) {
                        $size = $size_row['size'];
                        $color = $size_row['color'];
                        echo "<button class='size-button hidden' data-color='$color' data-size='$size'>$size</button>";
                    }
                    ?>
                    </ul>
                    </div>

                    <div class="stock-quantity">
                        <p>Stock: <?php echo $product_details['stock_quantity']; ?> </p>
                    </div>

                <div class="product-action">
                <form action="process-cart.php" method="POST" class="product-form">
                    
                    <input type="hidden" name="product_id" value="<?php echo $product_details['id']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $product_details['name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $product_details['price']; ?>">
                    <input type="hidden" name="product_stock_quantity" value="<?php echo $product_details['stock_quantity']; ?>">

                    <input type="hidden" id="selected_color" name="selected_color" value="">
                     <input type="hidden" id="selected_size" name="selected_size" value="">
                    
                    
                    <label for="quantity">Quantity:</label>

                    <input type="number" id="quantity" name="quantity" value="1" min="1">

                    <tr>
                    <td colspan="2">
                       
                        <input type="submit" name="add_to_cart" value="Add to Cart" class="btn-secondary">
                    </td>
                </tr>

                
                </form>
                </div>
            </div>

            <?php
            
        } 
        else
         {
            echo "<div class='error'>Product not found.</div>";
        }
    } 
    else
    {
        echo "<div class='error'>Error fetching product details.</div>";
    }
}
 else
{
    echo "<div class='error'>Invalid product ID.</div>";
}
?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    
    // Ensure that the imageZoom function is defined
    function imageZoom(imgID, resultID) {
        var img, result;
        img = document.getElementById(imgID);
        result = document.getElementById(resultID);

        img.addEventListener("mouseenter", function (e) {
            result.style.display = "block"; // Show the result div
        });

        img.addEventListener("mouseleave", function (e) {
            result.style.display = "none"; // Hide the result div
        });

        // Rest of your image zoom code...
    }

    // Call the imageZoom function
    imageZoom("product-image", "myresult");

    function showImage(imagePath) {
    
}
</script>
<script src="scripts/imagezoom.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/themes/default.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>


<script>
 // Function to handle color button click
$(".color-button").click(function () {
    var selectedColor = $(this).data("color");

    // Remove "selected-button" class from all color buttons
    $(".color-button").removeClass("selected-button");

    // Add "selected-button" class to the clicked color button
    $(this).addClass("selected-button");

    // Show size buttons for the selected color
    $(".size-button").addClass("hidden");
    $(".size-button[data-color='" + selectedColor + "']").removeClass("hidden");

    // Get the selected size
    var selectedSize = $(".size-button.selected-button").data("size");

    // Update the hidden form fields with selected color and size
    $("#selected_color").val(selectedColor);
    $("#selected_size").val(selectedSize);

    // Send an AJAX request to fetch stock quantity
    $.ajax({
        type: "POST",
        url: "get_stock_quantity.php",
        data: {
            product_id: <?php echo $product_id; ?>,
            color: selectedColor,
            size: selectedSize
        },
        success: function (response) {
            // Update the stock quantity display
            $(".stock-quantity p").text("Stock: " + response + " pieces");
        }
    });
});

// Function to handle size button click
$(".size-button").click(function () {
    var selectedSize = $(this).data("size");

    // Remove "selected-button" class from all size buttons
    $(".size-button").removeClass("selected-button");

    // Add "selected-button" class to the clicked size button
    $(this).addClass("selected-button");

    // Get the selected color
    var selectedColor = $(".color-button.selected-button").data("color");

    // Update the hidden form fields with selected color and size
    $("#selected_color").val(selectedColor);
    $("#selected_size").val(selectedSize);

    // Send an AJAX request to fetch stock quantity
    $.ajax({
        type: "POST",
        url: "get_stock_quantity.php",
        data: {
            product_id: <?php echo $product_id; ?>,
            color: selectedColor,
            size: selectedSize
        },
        success: function (response) {
            // Update the stock quantity display
            $(".stock-quantity p").text("Stock: " + response + " pieces");
        }
    });
});

// Function to handle "Add to Cart" button click
$(".product-form").submit(function (event) {
   

    // Check if a color and size are selected
    var selectedColor = $("#selected_color").val();
    var selectedSize = $("#selected_size").val();

    if (selectedColor === "" || selectedSize === "") {
        
        
        alert("Please choose both color and size.");

        
        return; // Exit the function if either color or size is not selected
    }

    var inputQuantity = parseInt($("#quantity").val());
    var stockQuantity = 0; // Initialize stock quantity

    // Get the current stock quantity using an AJAX request
    $.ajax({
        type: "POST",
        url: "get_stock_quantity.php",
        data: {
            product_id: <?php echo $product_id; ?>,
            color: selectedColor,
            size: selectedSize
        },
        success: function (response) {
            stockQuantity = parseInt(response);
            

            // Check if input quantity exceeds stock quantity
            if (inputQuantity > stockQuantity) {
                alert("Quantity exceeds available stock!");

                

                

                

                
            } else {
                // Quantity is valid, proceed to add to cart
                addToCart(inputQuantity); // Pass the input quantity to the addToCart function
                console.log(response);
            }
        }
    });
});


// Function to add the product to the cart
function addToCart(inputQuantity) {
    console.log("Before AJAX request");
    // Add your code here to submit the form or take any other action
    // For example, you can use AJAX to add the product to the cart
    $.ajax({
        type: "POST",
        url: "process-cart.php", // Replace with the actual URL to add to the cart
        data: {
            product_id: <?php echo $product_id; ?>,
            color: $("#selected_color").val(),
            size: $("#selected_size").val(),
            quantity: inputQuantity // Use the input quantity here
        },
        success: function (response) {
            // Handle the response (e.g., show a success message)
            console.log(response);
        }
    });
}


</script>










<?php
// Recommendation section
?>
<div class="recommendation-section">
    <h2>Recommended Products</h2>
    <br><br>
    <div class="recommended-products">
        <?php

        // Fetch recommended products from the database
        // Replace this query with your actual logic to fetch recommendations
        $recommended_sql = "SELECT * FROM product_list WHERE status = '1' AND id != $product_id LIMIT 6";
        $recommended_res = mysqli_query($conn, $recommended_sql);

        if ($recommended_res && mysqli_num_rows($recommended_res) > 0) {
            while ($recommended_product = mysqli_fetch_assoc($recommended_res)) {
                ?>
                <div class="recommended-product">
                    <a href="product-details.php?id=<?php echo $recommended_product['id']; ?>">
                        <img src="<?php echo SITEURL; ?>images/bike/<?php echo $recommended_product['image_path']; ?>"
                             alt="<?php echo $recommended_product['name']; ?>"
                             style="width: 150px;">
                        <h3><?php echo $recommended_product['name']; ?></h3>
                        <p>₱<?php echo $recommended_product['price']; ?></p>
                    </a>
                </div>
                <?php
            }
        } 
        else
         {
            echo "<p>No recommended products available.</p>";
        }
        ?>
    </div>
</div>

<?php
include('partials-front/footer.php');
?>
