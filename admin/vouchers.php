<?php include ('partials/menu.php');?>

<div class = "main-content">
           <div class = "wrapper">
                <h1>Discounts</h1>


                    <br/>

                 
                     <br/><br/><br/>

                  
                     <br/><br/><br/>

                 <table class= "tbl-full">
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Client ID</th>
                        <th>Amount</th>
                        <th>Expiration Date</th>
                        <th>Is redeemed</th>
                        <th>Redeemed Date</th>
                        <th>Created At</th>
                        <th>Action</th>

                    </tr>

                    <?php 
                    $sql = "SELECT * FROM vouchers";
                    $res = mysqli_query($conn,$sql);

                    if($res==TRUE)
                    {
                        $count = mysqli_num_rows($res);

                        $sn=1;

                        if($count>0)
                        {
                            while($rows=mysqli_fetch_assoc($res))
                            {
                                $id=$rows['voucher_id'];
                                $code=$rows['code'];
                                $client_id=$rows['client_id'];
                                $amount = $rows['amount'];
                                $expiration_date = $rows['expiration_date'];
                                $is_redeemed = $rows['is_redeemed'];
                                $redeemed_date = $rows['redeemed_date'];
                                $created_at = $rows['created_at'];
                                ?>

                    <tr>
                        <td><?php echo $sn++;?></td>
                        <td><?php echo $code;?></td>
                        <td><?php echo $client_id;?></td>
                        <td><?php echo $amount;?></td>  
                        <td><?php echo $expiration_date?></td>
                        <td style="background-color: <?php echo ($is_redeemed == 1) ? 'green' : 'red';?>">
                            <?php echo ($is_redeemed == 1) ? 'Yes' : 'No';?>
                        </td>
                        <td><?php echo $redeemed_date?></td>
                        <td><?php echo $created_at?></td>
                        <th>
                           
                        <a href="<?php echo SITEURL; ?>admin/delete-voucher.php?voucher_id=<?php echo $id; ?>" class="btn-third">Delete Voucher</a>




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
                 <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            </div>
        </div>
       
<?php include('partials/footer.php') ?>

