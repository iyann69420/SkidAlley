<?php
include('./config/constants.php');

$selectedCategories = $_GET['categories'] ?? [];
$selectedBrands = $_GET['brands'] ?? [];
$selectedColors = $_GET['colors'] ?? [];
$selectedSizes = $_GET['sizes'] ?? [];

$selectedCategories = array_map('intval', $selectedCategories);
$selectedBrands = array_map('intval', $selectedBrands);
$selectedColors = array_map('mysqli_real_escape_string', $selectedColors);
$selectedSizes = array_map('mysqli_real_escape_string', $selectedSizes);

$sql = "SELECT pl.id, pl.name, pl.description, pl.image_path, pl.price, sl.quantity AS stock_quantity 
        FROM product_list pl 
        LEFT JOIN stock_list sl ON pl.id = sl.product_id 
        LEFT JOIN product_colors_sizes pcs ON pcs.product_id = pl.id
        WHERE pl.status = '1'";

if (!empty($selectedCategories)) {
    $categoryList = implode(',', $selectedCategories);
    $sql .= " AND pl.category_id IN ($categoryList)";
}

if (!empty($selectedBrands)) {
    $brandList = implode(',', $selectedBrands);
    $sql .= " AND pl.brand_id IN ($brandList)";
}

if (!empty($selectedColors)) {
    $colorConditions = array_map(function ($color) {
        return "FIND_IN_SET('$color', pcs.color) > 0";
    }, $selectedColors);
    $colorCondition = implode(' OR ', $colorConditions);
    $sql .= " AND ($colorCondition)";
}

if (!empty($selectedSizes)) {
    $sizeConditions = array_map(function ($size) {
        return "FIND_IN_SET('$size', pcs.size) > 0";
    }, $selectedSizes);
    $sizeCondition = implode(' OR ', $sizeConditions);
    $sql .= " AND ($sizeCondition)";
}

$sql .= " GROUP BY pl.id";

$res = mysqli_query($conn, $sql);

// Build and return the filtered product list
if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $id = $row['id'];
        $title = $row['name'];
        $description = $row['description'];
        $image_name = $row['image_path'];
        $price = $row['price'];
        $stock = $row['stock_quantity'];

        ?>

        <div class="bikelist">
            <div class="bikes">
                <?php
                //check image if available
                if ($image_name == "") {
                    echo "<div class ='error'>Image not Available</div>";
                } else {
                    //image available
                ?>
                    <a href="product-details.php?id=<?php echo $id; ?>">
                        <img src="<?php echo SITEURL; ?>images/bike/<?php echo $image_name ?>" style="width: 300px">
                    </a>
                <?php
                }

                ?>
                <h2> Product Name: <?php echo $title; ?> </h2>
                <p> Price: <?php echo $price; ?> </p>

            </div>

        </div>
    <?php
    }
} else {
    echo '<div class="error">No products found.</div>';
}

// Close database connection
mysqli_close($conn);
?>
