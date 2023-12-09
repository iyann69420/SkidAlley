<?php include('partials-front/menu.php'); ?>
<br>

<div class="searchsection">
    <form action="<?php echo SITEURL; ?>product-search.php" method="GET">
        <input id="searchbar" type="text" name="search" placeholder="Search Products" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit" id="searchbutton">Search</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.checkbox-category, .checkbox-brand').change(function() {
                filterProducts();
            });
        });

        function filterProducts() {
            var selectedCategories = [];
            $('.checkbox-category:checked').each(function() {
                selectedCategories.push($(this).val());
            });

            var selectedBrands = [];
            $('.checkbox-brand:checked').each(function() {
                selectedBrands.push($(this).val());
            });

            $.ajax({
                type: "GET",
                url: "filter-products.php",
                data: {
                    categories: selectedCategories,
                    brands: selectedBrands
                },
                success: function(response) {
                    $("#product-list").html(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
    




    </div>
    <br><br>

<div class="sidebar">

    <h2>Categories</h2>
    <ul>
        <?php
        // Fetch and display categories
        $categorySql = "SELECT * FROM categories WHERE status = '1'";
        $categoryRes = mysqli_query($conn, $categorySql);
        while ($categoryRow = mysqli_fetch_assoc($categoryRes)) 
        {
            $categoryId = $categoryRow['id'];
            $categoryName = $categoryRow['category'];
            ?>
            <li>
                <label>
                <input type="checkbox" class="checkbox-category" name="category[]" value="<?php echo $categoryId; ?>">
                <span class="checkbox-text"><?php echo $categoryName ?></span> 
                </label>
            </li>
            <?php
        }
        ?>
    </ul>
    <br><br>
    <h2>Brands</h2>
    <ul>
        <?php
        // Fetch and display brands
        $brandSql = "SELECT * FROM brand_list WHERE status = '1'";
        $brandRes = mysqli_query($conn, $brandSql);
        while ($brandRow = mysqli_fetch_assoc($brandRes))
         {
            $brandId = $brandRow['id'];
            $brandName = $brandRow['name'];
            ?>
            <li>
                <label>
                    <input type="checkbox" class="checkbox-brand" name="brand[]" value="<?php echo $brandId; ?>">
                    <span class="checkbox-text"><?php echo $brandName ?></span>
                </label>
            </a></li>
            <?php
        }
        ?>
    </ul>
</div>

    

<div class="bikelist-container clearfix">
    <br><br>
    <?php
    if (isset($_GET['search'])) {
        $search = $_GET['search'];

        // Modify the query accordingly
        $query = "SELECT * FROM `product_list` WHERE `name` LIKE '%$search%' AND `status` = 1 AND `delete_flag` = 0";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $numRows = mysqli_num_rows($result);

            if ($numRows > 0) {
                echo '<h1> You Searched: "' . $search . '"</h1>';
                echo '<br><br>';

                // Display search results
                while ($row = mysqli_fetch_assoc($result)) 
                {
                    $id = $row['id'];
                    $title = $row['name'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $image_name = $row['image_path'];
                    ?>
                    
                    <div class="bikelist">
                        <div class="bikes">
                            <br>
                            <?php
                            // Display product image
                            if ($image_name == "")
                            {
                                echo "<div class='error'>Image not Available</div>";
                            } else 
                            {
                                echo '<a href="product-details.php?id=' . $id . '">';
                                echo '<img src="' . SITEURL . 'images/bike/' . $image_name . '" style="width: 300px">';
                                echo '</a>';
                            }
                            ?>
                            <h2><?php echo $title; ?></h2>
                            <p>PHP<?php echo $price;?></p>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<h1> You Searched: "' . $search . '"</h1>';
                echo '<br><br><br><br>';
                echo '<div style="margin-left: 30px;"><span style="font-size: 24px;">No products found</span></div>';

            }
        } else {
            echo 'Error in executing the query.';
        }
    }
    ?>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</div>

<?php include('partials-front/footer.php'); ?>
