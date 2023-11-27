<?php include('partials-front/menu.php'); ?>
<br>



<html>
<div class="searchsection">
    <form action="<?php echo SITEURL; ?>services-search.php" method="GET">
        <input id="searchbar" type="text" name="search" placeholder="Search Services">
        <button type="submit" id="searchbutton">Search</button>
    </form>
   </div>


    </div>
   
    <div class="service-container clearfix">
    <br><br>
    <h1> Our Services</h1>

    <!-- Check for session messages and display them -->
    <?php
    if (isset($_SESSION['add'])) {
        echo $_SESSION['add'];
        unset($_SESSION['add']);
    }

    if (isset($_SESSION['login'])) {
        echo $_SESSION['login'];
        unset($_SESSION['login']);
    }
    ?>

    <br><br>

    <?php
    // Retrieve services from the database
    $sql = "SELECT * FROM service_list"; 
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $count = mysqli_num_rows($res);

        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $title = $row['service'];
                $description = $row['description'];
                ?>
            
            <div class="servicelist">
                <div class="service">
                    <h2 class="service-name"><?php echo $title; ?></h2>
                    <p class="service-description"><?php echo $description; ?></p>
                </div>
            </div>
            <?php
            }
        } else {
            echo "<div class='error'>No services available.</div>";
        }
    } else {
        echo "<div class='error'>Error retrieving services.</div>";
    }
    ?>

</div>
  
</body>

</html>

<?php include('partials-front/footer.php'); ?>