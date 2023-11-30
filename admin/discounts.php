<?php include ('partials/menu.php');?>

<div class = "main-content">
           <div class = "wrapper">
                <h1>Discounts</h1>


                    <br/>

                 
                     <br/><br/><br/>

                  <a href="add-discounts.php" class="btn-primary">Add Discounts</a>
                     <br/><br/><br/>

                 <table class= "tbl-full">
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Discount Percentage</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Created</th>
                        <th>Action</th>

                    </tr>

                    <?php 
                    $sql = "SELECT * FROM discounts";
                    $res = mysqli_query($conn,$sql);

                    if($res==TRUE)
                    {
                        $count = mysqli_num_rows($res);

                        $sn=1;

                        if($count>0)
                        {
                            while($rows=mysqli_fetch_assoc($res))
                            {
                                $id=$rows['id'];
                                $product_id=$rows['product_id'];
                                $discount_percentage=$rows['discount_percentage'];
                                $start_time = $rows['start_time'];
                                $end_time = $rows['end_time'];
                                $created_at = $rows['created_at'];
                                ?>

                    <tr>
                        <td><?php echo $sn++;?></td>
                        <td><?php echo $product_id;?></td>
                        <td>%<?php echo $discount_percentage;?></td>
                        <td><?php echo $start_time;?></td>
                        <td style="<?php echo (strtotime($end_time) < time()) ? 'background-color: red;' : ''; ?>"><?php echo $end_time;?></td>
                        <th><?php echo $created_at;?></th>
                        <th>
                            <a href="<?php echo SITEURL; ?>admin/update_discounts.php?id=<?php echo $id; ?>" class='btn-secondary'>Update Discount</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-discount.php?id=<?php echo $id; ?>" class="btn-third">Delete Discount</a>

                            </th>

                    </tr>
                    <?php
                        }
                    } else {
                        // Handle the case where there are no discounts
                    }
                }
                    ?>
                   
                 </table>
             
            </div>
        </div>
<?php include('partials/footer.php') ?>