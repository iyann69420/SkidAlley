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

                    <tr>
                        <td>1</td>
                        <td>Bike Red</td>
                        <td>.05%</td>
                        <td>09/23/23</td>
                        <td>10/23/23</td>
                        <th>08/23/23</th>
                        <th>
                            <a href="<?php echo SITEURL; ?>admin/update-discount.php?id=<?php echo $id; ?>" class='btn-secondary'>Update Discount</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-discount.php?id=<?php echo $id; ?>" class="btn-third">Delete Discount</a>

                        </th>


                    </tr>


                   


                   
                 </table>
             
            </div>
        </div>
<?php include('partials/footer.php') ?>