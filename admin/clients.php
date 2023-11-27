<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Client List</h1>

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
        <br/><br/><br/>

        <table class="tbl-full">
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Fullname</th>
                 <th>Address</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>

            <?php
            $sql = "SELECT * FROM client_list";
            $res = mysqli_query($conn, $sql);

            if ($res == TRUE) {
                $count = mysqli_num_rows($res);

                $sn = 1;

                if ($count > 0) {
                    while ($rows = mysqli_fetch_assoc($res)) {
                        $id = $rows['id'];
                        $username = $rows['username'];
                        $fullname = $rows['fullname'];
                        $contact = $rows['contact'];
                        $address = $rows['address'];
                        $email = $rows['email'];
                       

                        

                        ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $username; ?></td>
                            <td><?php echo $fullname; ?></td>
                            <td><?php echo $address; ?></td>
                            <td><?php echo $contact; ?></td>
                            <td><?php echo $email; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-client.php?id=<?php echo $id; ?>"  class="btn-secondary">Update Client</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-client.php?id=<?php echo $id; ?>" class="btn-third">Delete Client</a>

                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    // Display a message when there are no customers
                    echo "<td colspan='5'><div class='error'>No Clients Found.</div></td>";
                }
            }
            ?>
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
