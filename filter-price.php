<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<?php include('partials-front/menu.php');
if (!isset($_SESSION['userLoggedIn'])) {
    header("Location: login.php");
    exit();
} ?>
<style>
.filtered-product-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin: 20px;
    width: 80%; /* Adjust the width of the container to your preference */
    margin: 0 auto; /* Center the container */
}

.filtered-product {
    width: 100%; /* Adjust the width to fit each column */
    box-sizing: border-box;
    padding: 10px;
    max-width: 300px; /* Set a fixed width for each product */
    text-align: center; /* Center the content within each product */
}

.filtered-product a {
    text-decoration: none;
    color: #333;
}

.filtered-product img {
    width: 100%;
    height: auto;
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
</style>
<?php



// Assuming you have a database connection established
if (isset($_GET['min-price']) && isset($_GET['max-price'])) {
    $minPrice = $_GET['min-price'];
    $maxPrice = $_GET['max-price'];
    $category = $_GET['category_id']; // Assuming 'category' is the name attribute of your category select input
    $brand = $_GET['brand']; // Assuming 'brand' is the name attribute of your brand select input

    $sql = "SELECT * FROM product_list WHERE price BETWEEN $minPrice AND $maxPrice";

    if (!empty($category)) {
        $sql .= " AND category_id = $category";
    }

    if (!empty($brand)) {
        $sql .= " AND brand_id = $brand";
    }

    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        while ($product = mysqli_fetch_assoc($res)) {
            ?>
            <div class="filtered-product">
                <a href="product-details.php?id=<?= $product['id'] ?>">
                    <img src="<?= SITEURL ?>images/bike/<?= $product['image_path'] ?>" alt="<?= $product['name'] ?>" style="width: 250px;">
                    <h3><?= $product['name'] ?></h3>
                    <p>Price: <?= $product['price'] ?></p>
                </a>
                
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br>
            <?php
        }
    } else {
        echo "<p>No products available within the specified criteria.</p>";
    }
}

?>
<?php include('partials-front/footer.php');?>

