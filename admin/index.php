<?php include ('partials/menu.php');?>

        <div class = "main-content">
           <div class = "wrapper">
                <h1>DASHBOARD</h1>
                <br><br>

                  <?php
                        if(isset($_SESSION['login']))
                        {
                        echo $_SESSION['login'];
                        unset($_SESSION['login']);
                        }
                  
                  ?>
                  <br><br>

    


               

                <div class = "col-4 text-center">

                      <?php

                      $sql =  "SELECT * FROM product_list";
                      $res = mysqli_query($conn,$sql);
                      $count = mysqli_num_rows($res);

                      ?>
                      <h1><?php echo $count;?></h1>
                       Product List

                </div>

                

                <div class = "col-4 text-center">
                  
                  <?php

                  $sql2 =  "SELECT * FROM categories";
                  $res2 = mysqli_query($conn,$sql2);
                  $count2 = mysqli_num_rows($res2);

                  ?>
                      <h1><?php echo $count2;?></h1>
                       Categories

                </div>


                <div class = "col-4 text-center">
                  <?php

                  $sql5 =  "SELECT * FROM brand_list";
                  $res5 = mysqli_query($conn,$sql5);
                  $count5 = mysqli_num_rows($res5);

                  ?>
                      <h1><?php echo $count5;?></h1>
                       Brands

                </div>

                <div class = "col-4 text-center">
                  <?php

                  $sql6 =  "SELECT * FROM service_list";
                  $res6 = mysqli_query($conn,$sql6);
                  $count6 = mysqli_num_rows($res6);

                  ?>
                      <h1><?php echo $count6;?></h1>
                       Services

                </div>

                <div class = "col-4 text-center">
                  <?php

                  $sql3 =  "SELECT * FROM order_list";
                  $res3 = mysqli_query($conn,$sql3);
                  $count3 = mysqli_num_rows($res3);

                  ?>
                      <h1><?php echo $count3;?></h1>
                       Orders

                </div>

                <div class = "col-4 text-center">
                 <?php

                  $sql4 =  "SELECT * FROM client_list";
                  $res4 = mysqli_query($conn,$sql4);
                  $count4 = mysqli_num_rows($res4);

                  ?>
                      <h1><?php echo $count4;?></h1>
                       Clients

                </div>

                

           
                <div class = "clearfix"></div>
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br>
        </div>

<?php include('partials/footer.php') ?>

