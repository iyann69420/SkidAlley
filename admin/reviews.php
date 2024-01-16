<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Reviews</h1>

        <br /><br />
        <?php

        
        ?>
        
        <br><br>

       
        <br /><br /><br />

        <table class="tbl-full">
            <tr>
                <th>#</th>
                <th>Order Id</th>
                <th>Client Name</th>
                <th>Image</th>
                <th>Stars</th>
                <th>Review</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <?php
            $sql = "SELECT * FROM reviews";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            $sn = 1;

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $order_id = $row['order_id'];
                    $client_id = $row['client_id'];
                    $image = $row['image_path'];
                    $stars = $row['stars'];
                    $review_text = $row['review_text'];
                    $status = $row['approved']
                  ?>
                   
                    <tr>
                            <td><?php echo $sn++;?></td>
                            <td><?php echo $order_id;?></td>
                            <td><?php echo $client_id; ?></td>
                            <td>
                            <?php
                            if ($image == "") 
                            {
                                echo "<div class='error'>Image not Added.</div>";
                            } else {
                                ?>
                                <img src="<?php echo SITEURL; ?>images/reviews/<?php echo $image; ?>"
                                     width="100px">
                                <?php
                            }
                            ?>
                        </td>
                            <td><?php echo $stars; ?></td>
                            <td><?php echo $review_text?></td>
                            <td>
                                <?php
                                    echo ($status == 1) ? 'Yes' : 'No';
                                ?>
                            </td>

                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-reviews.php?id=<?php echo $id; ?>" class='btn-secondary'>Approve Review</a>
                                
                            </td>
                    </tr>
                    
                    <?php
                }
            } 
            else 
            {
             ?>
                <tr>
                    <td colspan='4'><div class='error'>No Service Added.</div></td>
                </tr>
                <?php
            }
            ?>

        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>