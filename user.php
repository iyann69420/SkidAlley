<?php include('partials-front/menu.php'); ?>
<br>

<html>
<div class="searchsection">
    <form action="<?php echo SITEURL; ?>product-search.php" method="GET">
        <input id="searchbar" type="text" name="search" placeholder="Search Products">
        <button type="submit" id="searchbutton">Search</button>
    </form>
   </div>


    </div>
   

    <div class="bikelist-container clearfix">
        <br><br>
        <h1> Featured Bikes</h1>
        <br><br>

        <?php

        $sql = "SELECT * FROM product_list WHERE status='1'";

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
                                <h2> Product Name: <?php echo $title; ?> </h2>
                                <p> Description: <?php echo $description; ?> </p>
                                <p> Stock: </p>
                                <p> Price: PHP<?php echo $price; ?></p>
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

<?php include('partials-front/footer.php'); ?>