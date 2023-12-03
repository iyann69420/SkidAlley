<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<style>
  .reviews-section {
    margin: 30px 20px;
  }

  .review-box {
    width: 97%;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    text-align: center;
  }

  .review {
    margin: 50px 0;
    display: flex;
    flex-direction: row; /* Change this back to 'row' */
    align-items: flex-start; /* Align items to the top */
    justify-content: space-between; /* Add this line to align client and stars */
  }

  .content {
    width: 60%; /* Adjust the width as needed */
  }

  .client-stars {
    display: flex;
    flex-direction: column; /* Change to column to stack client and stars vertically */
    align-items: flex-start; /* Align items to the top */
  }

  .review-text {
    margin-top: 15px;
  }

  .review p {
    font-size: 14px;
    margin-bottom: 15px;
    color: #555;
  }

  .star {
    color: #FFD700;
    font-size: 1.2em;
  }

  .timestamp {
    text-align: left;
    color: #555;
    font-size: 14px;
    margin-top: 150px; /* Adjust this margin to move timestamp below */
  }

  .color-size {
    text-align: center; /* Center content horizontally within .color-size */
    margin-top: 20px;
  }

  .review-image {
    width: 200px; /* Adjust the width as needed */
    height: 200px; /* Set a fixed height for the image */
    object-fit: cover; /* Maintain aspect ratio and cover the entire container */
    border-radius: 8px;
    margin-top: 15px;
    }

    .modal {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 50px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.9);
}

/* Style for the modal content */
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}

/* Style for the close button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}
</style>
<?php include('partials-front/menu.php'); ?>
<br><br><br><br><br><br><br>
<?php
if (isset($_SESSION['add'])) {
    echo $_SESSION['add'];
    unset($_SESSION['add']);
}
if(isset($row["id"])) {
    $id = $row["id"];
}

?>
<?php
$uniqueColors = [];
if (isset($_GET['id']) && is_numeric($_GET['id'])) 
{
    $product_id = $_GET['id'];
    $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;


    // Fetch product details from the database
    $sql = "SELECT pl.*, sl.quantity AS stock_quantity, d.discount_percentage
        FROM product_list pl 
        LEFT JOIN stock_list sl ON pl.id = sl.product_id 
        LEFT JOIN discounts d ON pl.id = d.product_id AND NOW() BETWEEN d.start_time AND d.end_time
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
                    <?php
                    $originalPrice = $product_details['price'];
                    $discountPercentage = $product_details['discount_percentage'];

                    if (!empty($discountPercentage) && $discountPercentage > 0) {
                        $discountedPrice = $originalPrice - ($originalPrice * $discountPercentage / 100);
                        echo "<p>Original Price: ₱" . number_format($originalPrice) . "</p>";
                        echo "<p>Discounted Price: ₱" . number_format($discountedPrice) . "</p>";
                    } else {
                        echo "<p>Price: ₱" . number_format($originalPrice) . "</p>";
                    }
                    ?>
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



<div class="reviews-section">
    <h2>Reviews</h2>
    <br><br>

    <!-- Filter options -->
    <form method="get" action="" id="filter-form">
    <input type="hidden" name="id" value="<?php echo $product_id; ?>">
        <label for="star-filter">Filter by Stars:</label>
        <select name="star-filter" id="star-filter">
            <option value="0">All</option>
            <?php
            // Display options for filtering by stars
            for ($i = 1; $i <= 5; $i++) {
                echo "<option value=\"$i\">$i star</option>";
            }
            ?>
        </select>

        <label for="sort-order">Sort Order:</label>
        <select name="sort-order" id="sort-order">
            <option value="asc">Oldest to Newest</option>
            <option value="desc">Newest to Oldest</option>
        </select>

        <label for="image-filter">Filter by Image:</label>
        <select name="image-filter" id="image-filter">
            <option value="all">All</option>
            <option value="with-image">With Image</option>
            <option value="without-image">Without Image</option>
        </select>
    </form>

    <div class="review-box">
    <?php
// Define default values for filters
$starFilter = isset($_GET['star-filter']) ? intval($_GET['star-filter']) : 0;
$sortOrder = isset($_GET['sort-order']) && $_GET['sort-order'] === 'desc' ? 'DESC' : 'ASC';
$imageFilter = isset($_GET['image-filter']) ? $_GET['image-filter'] : 'all';

// Fetch reviews for the current product with applied filters
if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $product_id = $_GET['id'];
    
    $reviews_sql = "SELECT 
        reviews.id AS review_id,
        reviews.order_id,
        reviews.client_id,
        reviews.stars,
        reviews.review_text,
        reviews.image_path,
        reviews.timestamp,
        order_list.id AS order_list_id,
        order_products.product_id,
        product_list.name AS product_name,
        order_products.color,  
        order_products.size
    FROM 
        reviews
    JOIN 
        order_list ON reviews.order_id = order_list.id
    JOIN 
        order_products ON order_list.id = order_products.order_id
    JOIN 
        product_list ON order_products.product_id = product_list.id
    WHERE
        product_list.id = $product_id";

    // Apply star filter
    if ($starFilter > 0) {
        $reviews_sql .= " AND reviews.stars = $starFilter";
    }

    // Apply image filter
    if ($imageFilter === 'with-image') {
        $reviews_sql .= " AND reviews.image_path IS NOT NULL";
    } elseif ($imageFilter === 'without-image') {
        $reviews_sql .= " AND reviews.image_path IS NULL";
    }

    // Apply sorting order
    $reviews_sql .= " ORDER BY reviews.timestamp $sortOrder";

    $reviews_res = mysqli_query($conn, $reviews_sql);

    if ($reviews_res) {
        if (mysqli_num_rows($reviews_res) > 0) {
            while ($review = mysqli_fetch_assoc($reviews_res)) {
                // Use the correct variable names
                $review_id = $review["review_id"];
                $order_id = $review["order_id"];
                $order_list_id = $review["order_list_id"];
                $product_id = $review["product_id"];
                $product_name = $review["product_name"];
                $client_id = $review["client_id"];

                // Fetch client details from client_list based on client_id
                $client_query = "SELECT username FROM client_list WHERE id = $client_id";
                $client_result = mysqli_query($conn, $client_query);
                $client_data = mysqli_fetch_assoc($client_result);
                $client_username = $client_data['username'];

                // Assuming you have these columns in your reviews table
                $stars = $review['stars'];
                $review_text = $review['review_text'];
                $timestamp = $review['timestamp'];
                $image_path = $review['image_path'];
                $color = $review['color'];
                $size = $review['size'];

                ?>
                <div class="review">
                    <div class="content">
                        <!-- Client and Stars Section -->
                        <div class="client-stars">
                            <p class="client">Client: <?php echo $client_username; ?></p>
                            <p class="stars">Stars:
                                <?php
                                // Display stars based on the number of stars in the review
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $stars) {
                                        echo '<span class="star">&#9733;</span>'; // Unicode character for a filled star
                                    } else {
                                        echo '<span class="star">&#9734;</span>'; // Unicode character for an empty star
                                    }
                                }
                                ?>
                            </p>
                        </div>

                        <!-- Review Text Section -->
                        <div class="review-text">
                            <p><?php echo $review_text; ?></p>
                        </div>

                        <!-- Timestamp Section -->
                        <p class="timestamp">Posted on: <?php echo $timestamp; ?></p>
                    </div>

                    <!-- Image Section -->
                    <img src="<?php echo SITEURL; ?>images/reviews/<?php echo $review['image_path']; ?>"
                        alt="Reviewer Image"
                        class="review-image"
                        onclick="openModal()">

                        <div id="reviewModal" class="modal">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <img id="reviewimage" class="modal-content">
                    </div>

                    <!-- Color and Size Section -->
                    <div class="color-size">
                        <p>Colors: <?php echo $color ?></p>
                        <p>Size: <?php echo $size ?></p>
                    </div>
                </div>
                <?php
                }
            } else {
                echo "<p>No reviews available for this product.</p>";
            }
        } else {
            echo "<p>Error fetching reviews: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p>Invalid product ID.</p>";
    }
    ?>


    </div>

    <script>

        function openModal() {
            var reviewImage = document.getElementById('reviewimage');
            var modal = document.getElementById('reviewModal');

            // Set the modal content to the clicked image source
            reviewImage.src = event.target.src;

            // Display the modal
            modal.style.display = 'block';
        }

        function closeModal() {
            document.getElementById('reviewModal').style.display = 'none';
        }
        // Add event listeners to dropdowns for automatic form submission
        const filterForm = document.getElementById('filter-form');
        const dropdowns = document.querySelectorAll('select');

        dropdowns.forEach(dropdown => {
            dropdown.addEventListener('change', () => {
                filterForm.submit();
            });
        });

        function setDropdownSelections() {
        const urlParams = new URLSearchParams(window.location.search);

        // Set star-filter dropdown
        const starFilter = urlParams.get('star-filter');
        if (starFilter !== null) {
            document.getElementById('star-filter').value = starFilter;
        }

        // Set sort-order dropdown
        const sortOrder = urlParams.get('sort-order');
        if (sortOrder !== null) {
            document.getElementById('sort-order').value = sortOrder;
        }

        // Set image-filter dropdown
        const imageFilter = urlParams.get('image-filter');
        if (imageFilter !== null) {
            document.getElementById('image-filter').value = imageFilter;
        }
    }

    // Call the setDropdownSelections function when the page loads
    window.onload = setDropdownSelections;
    </script>
</div>





<?php
// Recommendation section
?>
<div class="recommendation-section">
    <h2>Recommended Products</h2>
    <br><br>
    <div class="recommended-products">
    <?php
// Initialize $client_id to a default value (e.g., 0) or leave it undefined
$client_id = isset($client_id) ? $client_id : 0;

// Check if the user is logged in
if ($client_id > 0) {
    // Fetch recently purchased products for the current customer
    $recentlyPurchasedSql = "SELECT DISTINCT product_list.*
                            FROM order_list
                            JOIN order_products ON order_list.id = order_products.order_id
                            JOIN product_list ON order_products.product_id = product_list.id
                            WHERE order_list.client_id = $client_id
                            ORDER BY order_list.date_created DESC
                            LIMIT 6";

    $recentlyPurchasedRes = mysqli_query($conn, $recentlyPurchasedSql);

    if ($recentlyPurchasedRes && mysqli_num_rows($recentlyPurchasedRes) > 0) {
        while ($recentlyPurchasedProduct = mysqli_fetch_assoc($recentlyPurchasedRes)) {
            ?>
            <div class="recommended-product">
                <a href="product-details.php?id=<?php echo $recentlyPurchasedProduct['id']; ?>">
                    <img src="<?php echo SITEURL; ?>images/bike/<?php echo $recentlyPurchasedProduct['image_path']; ?>"
                        alt="<?php echo $recentlyPurchasedProduct['name']; ?>"
                        style="width: 150px;">
                    <h3><?php echo $recentlyPurchasedProduct['name']; ?></h3>
                    <p>₱<?php echo number_format($recentlyPurchasedProduct['price'], 2); ?></p>
                </a>
            </div>
            <?php
        }

        // Fill remaining slots with general recommendations
        $remainingSlots = 6 - mysqli_num_rows($recentlyPurchasedRes);
        if ($remainingSlots > 0) {
            // Fetch general recommended products from the database
            $generalRecommendedSql = "SELECT * FROM product_list WHERE status = 1 AND id != $product_id LIMIT $remainingSlots";
            $generalRecommendedRes = mysqli_query($conn, $generalRecommendedSql);

            if ($generalRecommendedRes && mysqli_num_rows($generalRecommendedRes) > 0) {
                while ($generalRecommendedProduct = mysqli_fetch_assoc($generalRecommendedRes)) {
                    ?>
                    <div class="recommended-product">
                        <a href="product-details.php?id=<?php echo $generalRecommendedProduct['id']; ?>">
                            <img src="<?php echo SITEURL; ?>images/bike/<?php echo $generalRecommendedProduct['image_path']; ?>"
                                alt="<?php echo $generalRecommendedProduct['name']; ?>"
                                style="width: 150px;">
                            <h3><?php echo $generalRecommendedProduct['name']; ?></h3>
                            <p>₱<?php echo number_format($generalRecommendedProduct['price'], 2); ?></p>
                        </a>
                    </div>
                    <?php
                }
            }
        }
    }
} else {
    // Fetch general recommended products from the database
    $generalRecommendedSql = "SELECT * FROM product_list WHERE status = 1 AND id != $product_id LIMIT 6";
    $generalRecommendedRes = mysqli_query($conn, $generalRecommendedSql);

    if ($generalRecommendedRes && mysqli_num_rows($generalRecommendedRes) > 0) {
        while ($generalRecommendedProduct = mysqli_fetch_assoc($generalRecommendedRes)) {
            ?>
            <div class="recommended-product">
                <a href="product-details.php?id=<?php echo $generalRecommendedProduct['id']; ?>">
                    <img src="<?php echo SITEURL; ?>images/bike/<?php echo $generalRecommendedProduct['image_path']; ?>"
                        alt="<?php echo $generalRecommendedProduct['name']; ?>"
                        style="width: 150px;">
                    <h3><?php echo $generalRecommendedProduct['name']; ?></h3>
                    <p>₱<?php echo number_format($generalRecommendedProduct['price'], 2); ?></p>
                </a>
            </div>
            <?php
        }
    }
}
?>
    </div>
</div>

<?php
include('partials-front/footer.php');
?>
