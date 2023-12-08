<?php include('partials-front/menu.php'); ?>
<br>

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
    

<html>
<div class="searchsection">
    <form action="<?php echo SITEURL; ?>product-search.php" method="GET">
        <input id="searchbar" type="text" name="search" placeholder="Search Products">
        <button type="submit" id="searchbutton">Search</button>
    </form>
   </div>


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

    

  
   
     
        <div class="bikelist-container clearfix" id="product-list">
        <br><br><br><br>
        <h1> Featured Bikes</h1>

        <br><br>

        <?php

        $sql = "SELECT pl.*, MAX(sl.quantity) AS stock_quantity, d.discount_percentage
        FROM product_list pl 
        LEFT JOIN stock_list sl ON pl.id = sl.product_id 
        LEFT JOIN discounts d ON pl.id = d.product_id AND NOW() BETWEEN d.start_time AND d.end_time
        WHERE pl.status = '1'
        GROUP BY pl.id, pl.name, pl.description, pl.image_path, pl.price, d.discount_percentage";

        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);

        if($count>0)
        {
            while($row=mysqli_fetch_assoc($res))
            {
                 $id = $row['id'];
                $title = $row['name'];
                $description = $row['description'];
                $image_name = $row['image_path'];
                $price = $row['price'];
                $stock = $row['stock_quantity'];
                $discountPercentage = $row['discount_percentage'];

                // Calculate discounted price
                $discountedPrice = $price - ($price * $discountPercentage / 100);
                
                ?> 

                <div class="bikelist">
                            <div class="bikes">
                                <?php
                                  //check image if available
                                   if($image_name=="")
                                   {
                                    echo "<div class ='error'>Image not Available</div>";
                                   }
                                   else
                                   {
                                    //image avaialable
                                    ?>
                                     <a href="product-details.php?id=<?php echo $id; ?>">
                                        <img src="<?php echo SITEURL; ?>images/bike/<?php echo $image_name ?>"
                                            style="width: 300px">
                                    </a>
                                    <?php
                                   }
                                
                                ?>
                                <h2>  <?php echo $title; ?> </h2>
                              
                              
                                <?php
                              if (!empty($discountPercentage) && $discountPercentage > 0) {
                                echo "<p class='price'>Price: ₱<span class='original-price'>" . number_format($price) . "</span></p>";
                                echo "<p class='discounted-price'>Discounted Price: ₱" . number_format($discountedPrice) . "</p>";
                            } else {
                                echo "<p class='price'>Price: ₱" . number_format($price) . "</p>";
                            }
                                ?>
                            </div> 
                        
                        </div>

                <?php 
            }

        }
        else
        {
            echo "<div class = 'error'>Product not Added. </div>";
        }
        
        
        
        
        
        ?>


        
    </div>

   
  
</body>

</html>
<br><br><br><br><br><br><br><br>
<?php include('partials-front/footer.php'); ?>