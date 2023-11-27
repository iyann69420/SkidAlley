<?php include('partials-front/menu.php'); ?>
<br>

<div class="searchsection">
    <form action="<?php echo SITEURL; ?>services-search.php" method="GET">
        <input id="searchbar" type="text" name="search" placeholder="Search Service" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit" id="searchbutton">Search</button>
    </form>
</div>

<div class="services-container clearfix">
    <br><br>
    <?php
    if (isset($_GET['search'])) {
        $search = $_GET['search'];

        // Modify the query accordingly
        $query = "SELECT * FROM `service_list` WHERE `service` LIKE '%$search%' AND `status` = 1 AND `delete_flag` = 0";
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
                echo '<h1> You Searched: "' . $search . '"</h1>';
                echo '<br><br>';
                echo 'No service found.';
            }
        } else {
            echo 'Error in executing the query.';
        }
    }
    ?>
</div>

<?php include('partials-front/footer.php'); ?>
