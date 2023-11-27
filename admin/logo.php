<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        
        <h1>Logo</h1>

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
        <a href="<?php echo SITEURL; ?>admin/add-logo.php" class="btn-primary">Add Logo</a>
        <br/><br/><br/>

        <table class="tbl-full">
            <tr>
                <th>#</th>
                <th>Logo</th>
                <th>Action</th>
               
            </tr>
            <?php
            $sql = "SELECT * FROM content_management_logo";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            $sn = 1;

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $logo = $row['logo'];
                  


                    

                    ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td>
                            <?php
                            if ($logo == "") 
                            {
                                echo "<div class='error'>Image not Added.</div>";
                            } else {
                                ?>
                                <img src="<?php echo SITEURL; ?>images/logo/<?php echo $logo; ?>"
                                     width="100px">
                                <?php
                            }
                            ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-logo.php?id=<?php echo $id; ?>"class='btn-secondary'>Update Logo</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-logo.php?id=<?php echo $id; ?>" class="btn-third">Delete Logo</a>
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
</div>

<?php include ('partials/footer.php');?>