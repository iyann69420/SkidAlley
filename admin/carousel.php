<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        
        <h1>Carousel</h1>

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
        <a href="<?php echo SITEURL; ?>admin/add-carousel.php" class="btn-primary">Add Image</a>
        <br/><br/><br/>

        <table class="tbl-full">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Action</th>
               
            </tr>
            <?php
            $sql = "SELECT * FROM content_management_carousel";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            $sn = 1;

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $image = $row['images'];
                  


                    

                    ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td>
                            <?php
                            if ($image == "") 
                            {
                                echo "<div class='error'>Image not Added.</div>";
                            } else {
                                ?>
                                <img src="<?php echo SITEURL; ?>images/carousel/<?php echo $image; ?>"
                                     width="100px">
                                <?php
                            }
                            ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-carousel.php?id=<?php echo $id; ?>"class='btn-secondary'>Update Image </a>
                            <a href="<?php echo SITEURL; ?>admin/delete-carousel.php?id=<?php echo $id; ?>" class="btn-third">Delete Image</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan='4'><div class='error'>No Image Added.</div></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>

<?php include ('partials/footer.php');?>