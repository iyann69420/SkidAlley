<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>About Us</h1>

        <br/>

        <?php
        if (isset($_SESSION['add'])) {
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
        <br><br>

        <a href="<?php echo SITEURL; ?>admin/add-aboutus.php" class="btn-primary">Add</a>

        <br/><br/><br/>

        <table class="tbl-full">
            <tr>
                <th>#</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>

            <?php
            $sql = "SELECT * FROM content_management_aboutus";
            $res = mysqli_query($conn, $sql);

            if ($res == TRUE) {
                $count = mysqli_num_rows($res);

                $sn = 1;

                if ($count > 0) {
                    while ($rows = mysqli_fetch_assoc($res)) {
                        $id = $rows['id'];
                        $aboutus = $rows['aboutus'];
                        ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td>
                                <span class="aboutus-description"><?php echo $aboutus; ?></span>
                            </td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-aboutus.php?id=<?php echo $id; ?>" class="btn-secondary">Update</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-aboutus.php?id=<?php echo $id; ?>" class="btn-third">Delete</a>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    echo "<td colspan='3'><div class='error'>No About Us Inputted.</div></td>";
                }
            }
            ?>
        </table>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</div>

<?php include('partials/footer.php'); ?>
