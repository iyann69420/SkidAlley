<?php include('partials-front/menu.php'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
<br><br><br><br><br><br>

<style>
    .ratings-container {
        display: flex;
        align-items: center;
    }

    .average-stars,
    .total-sold {
        display: inline-block;
        margin-right: 10px; /* Adjust the margin as needed */
    }

    .average-stars {
        font-size: 18px;
        color: gold; /* Star color */
    }
</style>
<body>
    
    <style>
    body {
            overflow-x: hidden; /* Prevent horizontal scrolling */
            margin: 0; /* Remove default body margin */
            padding: 0; /* Remove default body padding */
        }
    </style>

<div class="carousel">
    <?php
    // Assuming you have a database connection established
    $sql = "SELECT images FROM content_management_carousel"; // Adjust the query as needed
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $image_url = SITEURL . 'images/carousel/' . $row['images']; // Adjust the path as needed
    ?>
            <img src="<?php echo $image_url; ?>" alt="Carousel Image" class="carousel-image">
    <?php
        }
    } else {
        // If no images are available, you can display a default image or a message
        echo '<img src="images/default.jpg" alt="Default Image" class="carousel-image">';
    }
    ?>

    <div class="carousel-content">
        <h1>Welcome to Skid Alley Bike Shop</h1>
        <br>
        <p><strong>Your one-stop shop for quality bikes and accessories</strong></p>
        <p><strong>The first and only FIXED GEAR BIKE SHOP in DASMARIÑAS</strong></p>

        <a href="index.php" class="shop-button">Shop Now</a>
    </div>
</div>

    
    <script src="scripts/carousel.js"></script>

    <div class="filter-price">
        <h2>On a Tight Budget? Discover Your Perfect Choice Here</h2>
        <form action="filter-price.php" method="GET">
            <label for="category">Category:</label>
            <select name="category_id" id="category_id">
                                <?php
                                $sql = "SELECT DISTINCT category_id FROM category_brands";
                                $res = mysqli_query($conn, $sql);
                                $count = mysqli_num_rows($res);

                                if ($count > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $category_id = $row['category_id'];
                                        $category_sql = "SELECT * FROM categories WHERE id='$category_id' AND status='1'";
                                        $category_res = mysqli_query($conn, $category_sql);
                                        $category_row = mysqli_fetch_assoc($category_res);
                                        if ($category_row) {
                                            $title = $category_row['category'];
                                            echo '<option value="' . $category_id . '">' . $title . '</option>';
                                        }
                                    }
                                } else {
                                    echo '<option value="0">No Category Found</option>';
                                }
                                ?>
                            </select>

            <label for="brand">Brand:</label>
                <select name="brand" id="brand">
                    <option value="">Select a category first</option>
                </select>

                <label for="min-price">Min Price:</label>
                <input type="number" name="min-price" id="min-price" value="0">
                <label for="max-price">Max Price:</label>
                <input type="number" name="max-price" id="max-price">
                <input type="submit" value="Filter">
        </form>
    </div>

    <?php
$currentTime = date('Y-m-d H:i:s');
$discountedProductsSql = "SELECT pl.*, d.discount_percentage, AVG(r.stars) AS average_stars, COALESCE(SUM(op.quantity), 0) AS total_sold
                        FROM product_list pl
                        JOIN discounts d ON pl.id = d.product_id
                        LEFT JOIN order_products op ON pl.id = op.product_id
                        LEFT JOIN order_list ol ON op.order_id = ol.id
                        LEFT JOIN reviews r ON ol.id = r.order_id
                        WHERE d.discount_percentage > 0
                          AND (d.end_time IS NULL OR d.end_time >= '$currentTime')
                        GROUP BY pl.id, pl.name, pl.description, pl.image_path, pl.price, d.discount_percentage";
$discountedProductsResult = mysqli_query($conn, $discountedProductsSql);
?>

<div class="discounted-section" <?php echo ($discountedProductsResult && mysqli_num_rows($discountedProductsResult) > 0) ? '' : 'style="display: none;"'; ?>>
    <h2>Discounted Products</h2>
    <br><br>
    <div class="discounted-products">
        <?php
        if ($discountedProductsResult && mysqli_num_rows($discountedProductsResult) > 0) {
            while ($discountedProduct = mysqli_fetch_assoc($discountedProductsResult)) {
                $price = $discountedProduct['price'];
                $discountPercentage = $discountedProduct['discount_percentage'];
                $discountedPrice = $price - ($price * $discountPercentage / 100);
                $averageStars = round($discountedProduct['average_stars'], 1);
                $totalSold = $discountedProduct['total_sold'];
        ?>
                <div class="discounted-product">
                    <a href="product-details.php?id=<?php echo $discountedProduct['id']; ?>">
                        <img src="<?php echo SITEURL; ?>images/bike/<?php echo $discountedProduct['image_path']; ?>"
                            alt="<?php echo $discountedProduct['name']; ?>"
                            style="width: 150px;">
                        <h3><?php echo $discountedProduct['name']; ?></h3>
                        <?php
                        if (!empty($discountPercentage) && $discountPercentage > 0) {
                            echo "<p class='price'>Price: ₱<span class='original-price'>" . number_format($price) . "</span></p>";
                            echo "<p class='discounted-price'>Discounted Price: ₱" . number_format($discountedPrice) . "</p>";
                        } else {
                            echo "<p class='price'>Price: ₱" . number_format($price) . "</p>";
                        }
                        echo "<p class='average-stars'> ";
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $averageStars) {
                                echo "★"; // Full star
                            } else {
                                echo "☆"; // Empty star
                            }
                        }
                        echo "</p>";
                        echo "<p class='total-sold'>$totalSold sold</p>";
                        ?>
                    </a>
                </div>
        <?php
            }
        } else {
            echo "<p>No discounted products available.</p>";
        }
        ?>
    </div>
</div>





    <?php
$sqlAllCategories = "SELECT * FROM categories";
$resAllCategories = mysqli_query($conn, $sqlAllCategories);

if ($resAllCategories && mysqli_num_rows($resAllCategories) > 0) {
    while ($categoryRow = mysqli_fetch_assoc($resAllCategories)) {
        $categoryId = $categoryRow['id'];
        $categoryName = $categoryRow['category'];

        // Your SQL query to select products for the current category
        $sqlProducts = "SELECT pl.*, AVG(r.stars) AS average_stars, COUNT(DISTINCT ol.id) AS total_sold
                        FROM product_list pl
                        LEFT JOIN order_products op ON pl.id = op.product_id
                        LEFT JOIN order_list ol ON op.order_id = ol.id AND ol.status = 4
                        LEFT JOIN reviews r ON ol.id = r.order_id
                        WHERE pl.category_id = $categoryId
                        GROUP BY pl.id, pl.name, pl.description, pl.image_path, pl.price";

        $resProducts = mysqli_query($conn, $sqlProducts);

        if ($resProducts && mysqli_num_rows($resProducts) > 0) {
            ?>
            <div class="bikeset-section">
                <h2><?php echo $categoryName; ?> Set</h2>
                <br><br>
                <div class="bikeset-products">
                    <?php
                    while ($product = mysqli_fetch_assoc($resProducts)) {
                        $averageStars = round($product['average_stars'], 1);
                        $totalSold = $product['total_sold'];
                        ?>
                        <div class="bikeset-product">
                            <a href="product-details.php?id=<?php echo $product['id']; ?>">
                                <img src="<?php echo SITEURL; ?>images/bike/<?php echo $product['image_path']; ?>"
                                     alt="<?php echo $product['name']; ?>"
                                     style="width: 150px;">
                                <h3><?php echo $product['name']; ?></h3>
                                <p>Price: <?php echo number_format($product['price'], 2); ?></p>
                                <p class='average-stars'> 
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $averageStars) {
                                            echo "★"; // Full star
                                        } else {
                                            echo "☆"; // Empty star
                                        }
                                    }
                                    ?>
                                </p>
                                <p class='total-sold'><?php echo $totalSold; ?>sold</p>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        } else {
           
        }
    }
} else {
    echo "<p>No categories found.</p>";
}
?>

                    
            </div>
    </div>

  

    

</body>
</html>







<?php include('partials-front/footer.php'); ?>

<script>
    function fetchBrands() {
        var category_id = $("#category_id").val();
        var brandDropdown = $("#brand");

        if (category_id) {
            $.ajax({
                type: "GET",
                url: "fetch-brands.php",
                data: { categoryId: category_id }, // Use categoryId as the parameter name
                dataType: "html",
                success: function (response) {
                    if (response.trim() !== "") {
                        brandDropdown.html(response);
                    } else {
                        brandDropdown.html('<option value="">No Brands Found</option>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: " + status + " - " + error);
                }
            });
        } else {
            brandDropdown.html('<option value="">Select a Category First</option>');
        }
    }

    // Attach the event listener to the category dropdown
    $(document).ready(function () {
        $("#category_id").change(fetchBrands);

        $("form").submit(function (event) {
            var category = $("#category_id").val();
            var brand = $("#brand").val();
            var minPrice = $("#min-price").val();
            var maxPrice = $("#max-price").val();

            if (category === "" || brand === "" || minPrice === "" || maxPrice === "") {
                event.preventDefault();
                alertify.error("Please select a category and brand, and input both minimum and maximum prices.", 5);
            } else if (parseInt(minPrice) >= parseInt(maxPrice)) {
                event.preventDefault();
                alertify.error("Minimum price should be less than maximum price.", 5);
            }
        });
    });
</script>
