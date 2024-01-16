<style>
.filtered-product-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin: 20px;
    width: 80%;
    margin: 0 auto;
}

.filtered-product {
    box-sizing: border-box;
    padding: 10px;
    text-align: center;
    max-width: 300px; /* Optional: Set a maximum width for each item */
}

.filtered-product a {
    text-decoration: none;
    color: #333;
}

.filtered-product img {
    max-width: 100%;
    height: 200px; /* Set a fixed height for all images (adjust as needed) */
    object-fit: cover;
}

.filtered-product h3 {
    margin-top: 10px;
    font-size: 18px;
}

.filtered-product p {
    margin: 5px 0;
}

.filtered-product:hover {
    transform: translateY(-4px);
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

.suggested-heading {
        text-align: center;
        margin-bottom: 20px;
        font-size: 28px;
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



<?php
include('partials-front/menu.php');
?>
<br><br><br><br>
<?php

// Function to get discount percentage for a product
function getDiscountPercentage($conn, $productId) {
    $currentDateTime = date('Y-m-d H:i:s');

    $sql = "SELECT discount_percentage FROM discounts 
            WHERE product_id = $productId 
            AND start_time <= '$currentDateTime' 
            AND end_time >= '$currentDateTime'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['discount_percentage'];
    }

    // Return 0 if no discount
    return 0;
}

// Function to calculate discounted price
function calculateDiscountedPrice($price, $discountPercentage) {
    // Calculate discounted price
    $discountedPrice = $price - ($price * $discountPercentage / 100);
    
    // Ensure the discounted price is not negative
    return max($discountedPrice, 0);
}

// Function to get average stars and total sold for a product
function getProductStats($conn, $productId) {
    $sql = "SELECT AVG(r.stars) AS average_stars, COALESCE(SUM(op.quantity), 0) AS total_sold
            FROM product_list pl
            LEFT JOIN order_products op ON pl.id = op.product_id
            LEFT JOIN order_list ol ON op.order_id = ol.id
            LEFT JOIN reviews r ON ol.id = r.order_id
            WHERE pl.id = $productId
            AND ol.status = 4";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return [
            'average_stars' => $row['average_stars'],
            'total_sold' => $row['total_sold']
        ];
    }

    // Return default values if no data found
    return [
        'average_stars' => 0,
        'total_sold' => 0
    ];
}

if (isset($_GET['min-price']) && isset($_GET['max-price'])) {
    $minPrice = $_GET['min-price'];
    $maxPrice = $_GET['max-price'];
    $category = $_GET['category_id'];
    $brand = $_GET['brand'];

    $sql = "SELECT * FROM product_list WHERE price BETWEEN $minPrice AND $maxPrice";

    if (!empty($category)) {
        $sql .= " AND category_id = $category";
    }

    if (!empty($brand)) {
        $sql .= " AND brand_id = $brand";
    }

    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        ?>
        <div class="suggested-heading">
        <h2>Suggested</h2>
        </div>
        <br>
        <div class="filtered-product-container">
            <?php
            while ($product = mysqli_fetch_assoc($res)) {
                $discountPercentage = getDiscountPercentage($conn, $product['id']);
                $price = $product['price'];
                $discountedPrice = calculateDiscountedPrice($price, $discountPercentage);
                $productStats = getProductStats($conn, $product['id']);
                ?>
                
                <div class="filtered-product">
                    
                    <a href="product-details.php?id=<?= $product['id'] ?>">
                        <img src="<?= SITEURL ?>images/bike/<?= $product['image_path'] ?>" alt="<?= $product['name'] ?>" style="width: 250px;">
                        <h3><?= $product['name'] ?></h3>
                        
                        <?php
                        // Display prices with or without discounts
                        if (!empty($discountPercentage) && $discountPercentage > 0) {
                            echo "<p class='price'>Price: ₱<span class='original-price'>" . number_format($price) . "</span></p>";
                            echo "<p class='discounted-price'>Discounted Price: ₱" . number_format($discountedPrice) . "</p>";
                        } else {
                            echo "<p class='price'>Price: ₱" . number_format($price) . "</p>";
                        }
                        ?>
                        
                        <p class='average-stars'>
                            <?php
                            $averageStars = round($productStats['average_stars'], 1);
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $averageStars) {
                                    echo "★"; // Full star
                                } else {
                                    echo "☆"; // Empty star
                                }
                            }
                            ?>
                        </p>

                        <p class='total-sold'><?= $productStats['total_sold'] ?> sold</p>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    } else {
        echo "<p>No products available within the specified criteria.</p>";
    }
}

?>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<?php
include('partials-front/footer.php');
?>

