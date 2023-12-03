<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        
        <h1>G Cash Info</h1>

        <br/><br/>
        <?php
        
          if (isset($_SESSION['add'])) 
          {
              echo $_SESSION['add'];
              unset($_SESSION['add']);
          }
          if(isset($_SESSION['delete']))
          {
              echo $_SESSION['delete'];
              unset($_SESSION['delete']);
          }
          if(isset($_SESSION['update']))
          {
              echo $_SESSION['update'];
              unset($_SESSION['update']);
          }
      
        ?>
        <br/><br/>
        <a href="<?php echo SITEURL; ?>admin/add-gcash-info.php" class="btn-primary">Add / Update Info</a>
        <br/><br/><br/>

        <table class="tbl-full">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Number</th>
                <th>Action</th>
               
            </tr>
            <?php
            $sql = "SELECT * FROM gcash_infos";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            $sn = 1;

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $name = $row['name'];
                    $number = $row['number'];
                  

                    

                    ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td>
                            <?php echo $name; ?></span>
                        </td>
                        <td>
                            <?php echo $number; ?></span>
                        </td>
                        <td>
                           
                            <a href="<?php echo SITEURL; ?>admin/delete-gcash-info.php?id=<?php echo $id; ?>" class="btn-third">Delete Logo</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan='4'><div class='error'>No Logo Added.</div></td>
                </tr>
                <?php
            }
            ?>
        </table>
        
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</div>


<?php include ('partials/footer.php');?>